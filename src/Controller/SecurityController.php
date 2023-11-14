<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;


use App\Entity\User;


// This controller manage the logic of the security interface
class SecurityController extends FrontController
{

    // This function is responsible for rendering the login interface 
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request)
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

    // This function is responsible for rendering the account modifiying interface destined to the super admin
    #[Route(path: '/modify_account/{userid}', name: 'app_modify_account')]
    public function modify_account(UserInterface $currentUser, int $userid, AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = $this->userRepository->findOneBy(['id' => $userid]);

        if ($request->isMethod('GET')) {
            if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
                $this->addFlash('danger', 'Le compte ne peut être modifié');
                return $this->redirectToRoute('app_base');
            }
            return $this->render('services/accountservices/modify_account_view.html.twig', [
                'user'          => $user,
                'error'         => $error,
            ]);
        } else if ($request->isMethod('POST')) {

            $error = $authenticationUtils->getLastAuthenticationError();
            $usermod = $this->accountService->modifyAccount($request, $currentUser, $user);

            if ($usermod instanceof User) {
                $this->addFlash('success', 'Le compte ' . $usermod->getUsername() . ' a été modifié');
                return $this->redirectToRoute('app_base');
            };
            return $this->redirectToRoute('app_base');
        }
    }


    // This function is responsible for managing the logic of the account deletion
    #[Route(path: '/delete_account/basic', name: 'app_delete_account_basic')]
    public function delete_account_basic(Request $request): Response
    {
        $id = $request->query->get('id');
        $user = $this->userRepository->findOneBy(['id' => $id]);

        return $this->redirectToRoute('app_base');
    }

    // This function is responsible for managing the logic of the account deletion
    #[Route(path: '/delete_account', name: 'app_delete_account')]
    public function delete_account(Request $request): Response
    {
        $id = $request->query->get('id');

        $this->accountService->deleteUser($id);
        $this->addFlash('success',  'Le compte a été supprimé');

        return $this->redirectToRoute('app_base');
    }
}