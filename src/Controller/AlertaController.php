<?php

namespace App\Controller;

use App\Entity\Alerta;
use App\Entity\Prestamo;
use App\Form\AlertaType;
use App\Repository\AlertaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/alerta')]
final class AlertaController extends AbstractController
{
    #[Route(name: 'app_alerta_index', methods: ['GET'])]
    public function index(AlertaRepository $alertaRepository): Response
    {
        return $this->render('alerta/index.html.twig', [
            'alertas' => $alertaRepository->findAll(),
        ]);
    }

    #[Route('/new/{prestamo_id}', name: 'app_alerta_new', methods: ['GET', 'POST'])]
    public function new(int $prestamo_id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Buscamos el préstamo al que pertenece la alerta
        $prestamo = $entityManager->getRepository(Prestamo::class)->find($prestamo_id);

        if (!$prestamo) {
            $this->addFlash('error', 'El préstamo no existe.');
            return $this->redirectToRoute('app_prestamo_index');
        }

        $alertum = new Alerta();
        $alertum->setPrestamo($prestamo);
        $alertum->setEstado('pendiente');

        $form = $this->createForm(AlertaType::class, $alertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($alertum);
            $entityManager->flush();

            $this->addFlash('success', 'Alerta registrada correctamente.');

            return $this->redirectToRoute('app_alerta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alerta/new.html.twig', [
            'alertum' => $alertum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_alerta_show', methods: ['GET'])]
    public function show(Alerta $alertum): Response
    {
        return $this->render('alerta/show.html.twig', [
            'alertum' => $alertum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_alerta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Alerta $alertum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlertaType::class, $alertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_alerta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alerta/edit.html.twig', [
            'alertum' => $alertum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_alerta_delete', methods: ['POST'])]
    public function delete(Request $request, Alerta $alertum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alertum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($alertum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_alerta_index', [], Response::HTTP_SEE_OTHER);
    }
}
