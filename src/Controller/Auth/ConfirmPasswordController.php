<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConfirmPasswordController extends AbstractController
{
    /**
     * @Route("/confirm-password", name="app_confirm_password", methods={"GET", "POST"})
     */
    public function confirmPassword(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // Check if the user is authenticated
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Handle the form submission
        if ($request->isMethod('POST')) {
            $password = $request->request->get('password');

            // Verify the password
            $user = $this->getUser();
            $encoder = $this->container->get('security.password_encoder');
            if ($encoder->isPasswordValid($user, $password)) {
                // Redirect to the intended route or home
                return $this->redirectToRoute('home');
            }

            // Add an error message if the password is invalid
            $this->addFlash('error', 'Invalid password. Please try again.');
        }

        // Render the confirmation form
        return $this->render('auth/confirm_password.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}