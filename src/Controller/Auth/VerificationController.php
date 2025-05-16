<?php

namespace App\Controller\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class VerificationController extends AbstractController
{
    #[Route('/verify/email', name: 'app_verify_email', methods: ['GET'])]
    public function verifyEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User || $user->isVerified()) {
            return $this->redirectToRoute('home');
        }

        $verificationToken = $request->query->get('token');

        // Check if the token matches the user's verification token
        if ($user->getVerificationToken() !== $verificationToken) {
            $this->addFlash('error', 'Invalid verification token.');

            return $this->redirectToRoute('home');
        }

        // Mark the user as verified
        $user->setIsVerified(true);
        $user->setVerificationToken(null); // Clear the token after verification
        $entityManager->flush();

        $this->addFlash('success', 'Your email has been successfully verified.');

        return $this->redirectToRoute('home');
    }

    #[Route('/verify/resend', name: 'app_resend_verification_email', methods: ['POST'])]
    public function resendVerificationEmail(MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User || $user->isVerified()) {
            return $this->redirectToRoute('home');
        }

        // Generate a new verification token
        $verificationToken = bin2hex(random_bytes(32));
        $user->setVerificationToken($verificationToken);
        $entityManager->flush();

        // Send the verification email
        $verificationUrl = $this->generateUrl('app_verify_email', ['token' => $verificationToken], UrlGeneratorInterface::ABSOLUTE_URL);
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($user->getEmail())
            ->subject('Verify Your Email Address')
            ->html(sprintf('<p>Please verify your email by clicking <a href="%s">here</a>.</p>', $verificationUrl));

        $mailer->send($email);

        $this->addFlash('success', 'A new verification email has been sent to your email address.');

        return $this->redirectToRoute('home');
    }
}
