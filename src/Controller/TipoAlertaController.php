<?php

namespace App\Controller;

use App\Entity\TipoAlerta;
use App\Form\TipoAlertaType;
use App\Repository\TipoAlertaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tipo/alerta')]
final class TipoAlertaController extends AbstractController
{
    #[Route(name: 'app_tipo_alerta_index', methods: ['GET'])]
    public function index(TipoAlertaRepository $tipoAlertaRepository): Response
    {
        return $this->render('tipo_alerta/index.html.twig', [
            'tipo_alertas' => $tipoAlertaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tipo_alerta_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipoAlertum = new TipoAlerta();
        $form = $this->createForm(TipoAlertaType::class, $tipoAlertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipoAlertum);
            $entityManager->flush();

            $this->addFlash('success', '¡Tipo de alerta creada con éxito!');

            return $this->redirectToRoute('app_tipo_alerta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_alerta/new.html.twig', [
            'tipo_alertum' => $tipoAlertum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tipo_alerta_show', methods: ['GET'])]
    public function show(TipoAlerta $tipoAlertum): Response
    {
        return $this->render('tipo_alerta/show.html.twig', [
            'tipo_alertum' => $tipoAlertum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tipo_alerta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TipoAlerta $tipoAlertum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipoAlertaType::class, $tipoAlertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Tipo de alerta actualizada correctamente.');
            return $this->redirectToRoute('app_tipo_alerta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_alerta/edit.html.twig', [
            'tipo_alertum' => $tipoAlertum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tipo_alerta_delete', methods: ['POST'])]
    public function delete(Request $request, TipoAlerta $tipoAlertum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoAlertum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tipoAlertum);
            $entityManager->flush();

            $this->addFlash('success', 'Tipo de alerta eliminada.');
        }

        return $this->redirectToRoute('app_tipo_alerta_index', [], Response::HTTP_SEE_OTHER);
    }
}
