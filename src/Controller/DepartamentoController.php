<?php

namespace App\Controller;

use App\Entity\Departamento;
use App\Form\DepartamentoType;
use App\Repository\DepartamentoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/departamento')]
final class DepartamentoController extends AbstractController
{
    #[Route('/', name: 'app_departamento_index', methods: ['GET'])]
    public function index(DepartamentoRepository $departamentoRepository): Response
    {
        return $this->render('departamento/index.html.twig', [
            'departamentos' => $departamentoRepository->findAll(),
        ]);
    }

    #[Route('/new-ajax', name: 'app_departamento_new_ajax', methods: ['POST'])]
    public function newAjax(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['nombre'])) {
            return new JsonResponse(['success' => false, 'message' => 'Nombre no válido'], 400);
        }

        $departamento = new Departamento();
        $departamento->setNombre($data['nombre']);
        $departamento->setObservaciones($data['observaciones'] ?? '');

        $entityManager->persist($departamento);
        $entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'id' => $departamento->getId(),
            'nombre' => $departamento->getNombre()
        ]);
    }

    #[Route('/new', name: 'app_departamento_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $departamento = new Departamento();
        $form = $this->createForm(DepartamentoType::class, $departamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($departamento);
            $entityManager->flush();

            $this->addFlash('success', '¡Departamento creado con éxito!');

            return $this->redirectToRoute('app_departamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('departamento/new.html.twig', [
            'departamento' => $departamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_departamento_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departamento $departamento, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepartamentoType::class, $departamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', '¡Departamento actualizado con éxito!');

            return $this->redirectToRoute('app_departamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('departamento/edit.html.twig', [
            'departamento' => $departamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departamento_delete', methods: ['POST'])]
    public function delete(Request $request, Departamento $departamento, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departamento->getId(), $request->getPayload()->getString('_token'))) {
            // PASO EXTRA: Buscamos los usuarios de este departamento y los ponemos a null
            foreach ($departamento->getUsuarios() as $usuario) {
                $usuario->setDepartamento(null);
            }

            // Ahora que no hay nadie vinculado, podemos borrar sin miedo al error 1451
            $entityManager->remove($departamento);
            $entityManager->flush();

            $this->addFlash('success', 'Departamento eliminado. Los usuarios asociados ahora no tienen departamento.');

        }

        return $this->redirectToRoute('app_departamento_index', [], Response::HTTP_SEE_OTHER);
    }


}
