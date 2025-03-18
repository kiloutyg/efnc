<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// This controller manage the logic of the security interface
class SecurityController extends AbstractController
{

    public function __construct()
    {
        // Placeholder
    }

    // This function is responsible for rendering the login interface 
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) {
            $this->addFlash('success', 'Vous êtes connecté');
            return $this->redirectToRoute('app_base');
        }

        $error        = $authenticationUtils->getLastAuthenticationError(); // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('services/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'user'          => $this->getUser()
        ]);
    }

    // This function is responsible for rendering the logout interface
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        $this->addFlash('success', 'Vous êtes déconnecté');
    }
}
