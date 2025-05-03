<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot-password', name: 'app_forgot_password', methods: ['GET', 'POST'])]
    public function forgotPassword(Request $request, MailerInterface $mailer, UserProviderInterface $userProvider): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            // Find the user by email
            $user = $userProvider->loadUserByIdentifier($email);
            if (!$user) {
                $this->addFlash('error', 'No user found with this email address.');
                return $this->redirectToRoute('app_forgot_password');
            }

            // Generate a password reset token (you can use a service for this)
            $resetToken = bin2hex(random_bytes(32));

            // Send the reset email
            $resetUrl = $this->generateUrl('app_reset_password', ['token' => $resetToken], true);
            $emailMessage = (new Email())
                ->from('no-reply@example.com')
                ->to($email)
                ->subject('Password Reset Request')
                ->html(sprintf('<p>Click <a href="%s">here</a> to reset your password.</p>', $resetUrl));

            $mailer->send($emailMessage);

            $this->addFlash('success', 'A password reset link has been sent to your email address.');
            return $this->redirectToRoute('app_forgot_password');
        }

        return $this->render('auth/forgot_password.html.twig');
    }
}
