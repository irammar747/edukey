<?php

namespace App\Controller;

use App\Entity\Llave;
use App\Entity\Prestamo;
use App\Form\PrestamoType;
use App\Repository\PrestamoRepository;
use App\Repository\LlaveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/prestamo')]
final class PrestamoController extends AbstractController
{
    #[Route(name: 'app_prestamo_index', methods: ['GET'])]
    public function index(PrestamoRepository $prestamoRepository): Response
    {
        // Si el usuario tiene ROLE_PERSONAL o ROLE_ADMIN, ve todos los préstamos
        if ($this->isGranted('ROLE_PERSONAL') || $this->isGranted('ROLE_ADMIN')) {
            $prestamos = $prestamoRepository->findAll();
        } else {
            // Si es un ROLE_USER normal, solo ve los que él solicitó
            $prestamos = $prestamoRepository->findBy(['docente' => $this->getUser()]);
        }

        return $this->render('prestamo/index.html.twig', [
            'prestamos' => $prestamos,
        ]);
    }

    #[Route('/new', name: 'app_prestamo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, LlaveRepository $llaveRepository): Response
    {
        $prestamo = new Prestamo();

        // 1. Capturamos el ID de la llave de la URL si existe (venimos de la página de llaves)
        $idLlave = $request->query->get('llave');

        if ($idLlave) {
            $llave = $llaveRepository->find($idLlave);
            if ($llave) {
                if($llave->isDisponible()){
                    // 2. Asignamos la llave al objeto préstamo
                    $prestamo->setLlave($llave);
                }else{
                    //Si la llave no está disponible mostramos un error
                    $this->addFlash('error', 'La llave ' . $llave->getCodigo() . ' ya se encuentra prestada.');
                    return $this->redirectToRoute('app_llave_index');
                }
            }
        }

        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $llaveSeleccionada = $prestamo->getLlave();

           // Comprobamos de nuevo antes de guardar, por si alguien la prestó la llave en ese intervalo
            if (!$llaveSeleccionada->isDisponible()) {
                $this->addFlash('error', 'Lo sentimos, la llave seleccionada acaba de ser prestada por otro usuario.');
                return $this->redirectToRoute('app_llave_index');
            }

            //Si está disponible, la marcamos como prestada y guardamos el préstamo
            $prestamo->getLlave()->setDisponible(false);
            $prestamo->setPersonal($this->getUser()); //Asignamos como el usuario a la persona que atiende el préstamo

            $entityManager->persist($prestamo);
            $entityManager->flush();

            return $this->redirectToRoute('app_prestamo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prestamo/new.html.twig', [
            'prestamo' => $prestamo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prestamo_show', methods: ['GET'])]
    public function show(Prestamo $prestamo): Response
    {
        return $this->render('prestamo/show.html.twig', [
            'prestamo' => $prestamo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prestamo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prestamo $prestamo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_prestamo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prestamo/edit.html.twig', [
            'prestamo' => $prestamo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prestamo_delete', methods: ['POST'])]
    public function delete(Request $request, Prestamo $prestamo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestamo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($prestamo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prestamo_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/devolver-llave/{llave}', name: 'app_prestamo_devolver', methods: ['GET'])]
    public function devolverPorLlave(Llave $llave, PrestamoRepository $prestamoRepository, EntityManagerInterface $entityManager): Response {
        // 1. Buscar el préstamo activo de esta llave (donde f_devo sea null)
        $prestamo = $prestamoRepository->findOneBy([
            'llave' => $llave,
            'f_devo' => null
        ]);

        if (!$prestamo) {
            $this->addFlash('warning', 'No se encontró un préstamo activo para la llave: ' . $llave->getCodigo());
            return $this->redirectToRoute('app_llave_index');
        }

        return $this->ejecutarDevolucion($prestamo, $entityManager, 'app_llave_index');

    }

    #[Route('/finalizar-prestamo/{id}', name: 'app_prestamo_finalizar', methods: ['GET'])]
    public function finalizarPrestamo(Prestamo $prestamo, EntityManagerInterface $entityManager): Response
    {
        if ($prestamo->getFDevo() !== null) {
            $this->addFlash('info', 'Este préstamo ya estaba finalizado.');
            return $this->redirectToRoute('app_prestamo_index');
        }

        return $this->ejecutarDevolucion($prestamo, $entityManager, 'app_prestamo_index');
    }

    private function ejecutarDevolucion(Prestamo $prestamo, EntityManagerInterface $entityManager, string $routeRedirect): Response
    {
        // Registrar la devolución con la fecha y hora actual
        $prestamo->setFDevo(new \DateTimeImmutable());

        // Marcar la llave como disponible de nuevo
        $llave = $prestamo->getLlave();
        if ($llave) {
            $llave->setDisponible(true);
        }

        $entityManager->flush();

        $this->addFlash('success', '¡Llave ' . $llave->getCodigo() . ' devuelta con éxito!');
        return $this->redirectToRoute($routeRedirect);
    }

}
