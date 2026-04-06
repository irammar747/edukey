<?php

namespace App\Controller;

use App\Entity\Llave;
use App\Form\LlaveType;
use App\Repository\LlaveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/llave')]
final class LlaveController extends AbstractController
{
    #[Route(name: 'app_llave_index', methods: ['GET'])]
    public function index(LlaveRepository $llaveRepository): Response
    {
        return $this->render('llave/index.html.twig', [
            'llaves' => $llaveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_llave_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $llave = new Llave();
        $form = $this->createForm(LlaveType::class, $llave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($llave);
            $entityManager->flush();

            $this->addFlash('success', '¡Llave creada con éxito!');

            return $this->redirectToRoute('app_llave_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('llave/new.html.twig', [
            'llave' => $llave,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_llave_show', methods: ['GET'])]
    public function show(Llave $llave): Response
    {
        return $this->render('llave/show.html.twig', [
            'llave' => $llave,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_llave_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Llave $llave, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LlaveType::class, $llave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_llave_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('llave/edit.html.twig', [
            'llave' => $llave,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_llave_delete', methods: ['POST'])]
    public function delete(Request $request, Llave $llave, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$llave->getId(), $request->getPayload()->getString('_token'))) {

            // 1. Borramos los préstamos asociados a la llave
            foreach ($llave->getPrestamos() as $prestamo) {
                $entityManager->remove($prestamo);
            }

            $entityManager->remove($llave);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_llave_index', [], Response::HTTP_SEE_OTHER);
    }
}
