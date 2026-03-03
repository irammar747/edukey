<?php
namespace App\Service;

use App\Entity\Usuario;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendWelcomeInvitation(Usuario $usuario, string $resetUrl): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@edukey.com', 'EduKey System'))
            ->to($usuario->getEmail())
            ->subject('Bienvenido a EduKey - Crea tu contraseña')
            ->htmlTemplate('emails/welcome_invitation.html.twig')
            ->context([
                'usuario' => $usuario,
                'resetUrl' => $resetUrl,
                'expiresAt' => new \DateTime('+48 hours'),
            ]);

        $this->mailer->send($email);
    }

    public function sendResetPassword(Usuario $usuario, string $resetUrl): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('soporte@edukey.com', 'EduKey Soporte'))
            ->to($usuario->getEmail())
            ->subject('Restablecimiento de contraseña')
            ->htmlTemplate('emails/admin_password_reset.html.twig')
            ->context([
                'usuario' => $usuario,
                'resetUrl' => $resetUrl,
                'expiresAt' => new \DateTime('+48 hours'),
            ]);

        $this->mailer->send($email);
    }
}
