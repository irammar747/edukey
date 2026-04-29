<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\ChangePasswordFormType;
use App\Form\UserProfileType;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use App\Service\EmailService;

#[Route('/usuario')]
final class UsuarioController extends AbstractController
{
    #[Route(name: 'app_usuario_index', methods: ['GET'])]
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        return $this->render('usuario/index.html.twig', [
            // Ordenamos por 'nombre' de forma ascendente (A-Z)
            'usuarios' => $usuarioRepository->findBy([], ['username' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_usuario_new', methods: ['GET', 'POST'])]
    public function new(Request $request,
                        EntityManagerInterface $entityManager,
                        ResetPasswordHelperInterface $resetPasswordHelper,
                        EmailService $emailService): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 1. Asignamos un password aleatorio inicial (obligatorio pq el campo no puede ser null aunque la cuenta
            //estará bloqueada hasta que resetee la contraseña ya que nadie la sabe)
            $usuario->setPassword(bin2hex(random_bytes(20)));

            $entityManager->persist($usuario);
            $entityManager->flush();

            // 2. Generamos el token de recuperación
            try {
                $resetToken = $resetPasswordHelper->generateResetToken($usuario);

                // Creamos la URL que lleva al formulario de "poner contraseña"
                $url = $this->generateUrl('app_reset_password', [
                    'token' => $resetToken->getToken(),
                ], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL);

                // 3. Enviamos el mail de bienvenida
                $emailService->sendWelcomeInvitation($usuario, $url);

                $this->addFlash('success', 'Usuario creado con éxito. Se ha enviado un email de bienvenida.');
            } catch (\Exception $e) {
                $this->addFlash('warning', 'Usuario creado, pero hubo un error enviando el email: ' . $e->getMessage());
            }
            return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_usuario_show', methods: ['GET'])]
    public function show(Usuario $usuario): Response
    {
        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_usuario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Usuario $usuario, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Usuario actualizado correctamente.');
            return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_usuario_delete', methods: ['POST'])]
    public function delete(Request $request, Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->getPayload()->getString('_token'))) {

            // Recorremos y borramos todos los préstamos solicitados por usuario
            foreach ($usuario->getPrestamosSolicitados() as $prestamoSolicitado) {
                $entityManager->remove($prestamoSolicitado);
            }

            // También eliminamos los registrados poniendolos a null
            foreach ($usuario->getPrestamosRegistrados() as $prestamosRegistrado) {
                $prestamosRegistrado->setPersonal(null);
            }

            // Una vez vacía la relación, borramos al usuario
            $entityManager->remove($usuario);
            $entityManager->flush();

            $this->addFlash('success', 'Usuario eliminado con éxito.');
        }

        return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/reset-password-admin', name: 'app_usuario_reset_password_admin', methods: ['POST'])]
    public function resetPasswordAdmin(
        Usuario $usuario,
        ResetPasswordHelperInterface $resetPasswordHelper,
        EmailService $emailService
    ): Response {
        try {
            // 1. Generamos el token de recuperación
            $resetToken = $resetPasswordHelper->generateResetToken($usuario);

            // 2. Creamos la URL absoluta para el reset
            $url = $this->generateUrl('app_reset_password', [
                'token' => $resetToken->getToken(),
            ], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL);

            // 3. Usamos EmailService
            // usamos un metodo específico para "reset" diferente del de bienvenida
            $emailService->sendResetPassword($usuario, $url);

            $this->addFlash('success', 'Se ha enviado un nuevo enlace de acceso a ' . $usuario->getEmail());

        } catch (\SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface $e) {
            // El bundle de reset password a veces lanza excepciones si ya hay un token activo
            $this->addFlash('warning', 'No se pudo enviar el correo: ' . $e->getReason());
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Error inesperado: ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_usuario_index');
    }

    #[Route('/me/perfil', name: 'app_perfil', methods: ['GET'])]
    public function miPerfil(): Response
    {
        // Forzamos que se use el usuario logueado actualmente
        return $this->render('usuario/show.html.twig', [
            'usuario' => $this->getUser(),
            'is_my_profile' => true // Bandera para ajustar botones en la vista
        ]);
    }

    #[Route('/me/cambiar-password', name: 'app_perfil_password', methods: ['GET', 'POST'])]
    public function cambiarPassword(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    ): Response {
        $usuario = $this->getUser();

        // SEGURIDAD: Si no hay usuario, redirigir al login
        if (!$usuario) {
            return $this->redirectToRoute('app_login');
        }

        // 1. Creamos el objeto formulario
        $form = $this->createForm(ChangePasswordFormType::class);

        // 2. Le decimos que procese la petición (aquí Symfony lee el POST automáticamente)
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            // Si ves esto en pantalla, es que el navegador envía los datos
            // pero Symfony no los asocia al formulario.
            dump('Petición POST recibida');

            if (!$form->isSubmitted()) {
                dump('El formulario NO se considera enviado. Probablemente falta el Token CSRF o el nombre de los campos está mal.');
            }
        }

        if ($form->isSubmitted()) {
            // Esto mostrará una barra negra arriba con los datos que Symfony ha capturado
            dump($form->getData());
            // Esto dirá si el formulario es válido o por qué no lo es
            dump($form->getErrors(true, true));
        }

        // 3. Comprobamos si se ha enviado y si CUMPLE las reglas (min: 6, coincidencia, etc.)
        if ($form->isSubmitted() && $form->isValid()) {

            // Obtenemos el password del campo 'plainPassword' que definiste en el builder
            $nuevaClave = $form->get('plainPassword')->getData();

            $hashedPassword = $hasher->hashPassword($usuario, $nuevaClave);
            $usuario->setPassword($hashedPassword);
            $em->flush();

            $this->addFlash('success', 'Contraseña actualizada correctamente.');
            return $this->redirectToRoute('app_perfil');
        }

        // 4. Pasamos el formulario a la vista. ESTO EVITA EL ERROR DE "variable form does not exist"
        return $this->render('usuario/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/me/editar', name: 'app_perfil_edit', methods: ['GET', 'POST'])]
    public function editarMiPerfil(Request $request, EntityManagerInterface $entityManager): Response
    {
        $usuario = $this->getUser(); // Seguridad: siempre editamos al usuario logueado

        // Usamos el nuevo formulario restringido
        $form = $this->createForm(UserProfileType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Tus datos se han actualizado correctamente.');
            return $this->redirectToRoute('app_perfil');
        }

        return $this->render('usuario/edit_profile.html.twig', [
            'form' => $form,
            'usuario' => $usuario
        ]);
    }
}
