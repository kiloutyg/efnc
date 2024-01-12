<?php

namespace App\Controller;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Controller\FrontController;

use App\Entity\User;


#[Route('/', name: 'app_')]
class AccountController extends FrontController
{
    #[Route('/createAccount', name: 'create_account')]
    public function createAccount(Request $request): Response
    {
        if ($request->isMethod('GET')) {
            if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
                return $this->render('services/admin_services/accountservices/superadmin_create_account.html.twig');
            } else {
                return $this->render('services/admin_services/accountservices/create_account.html.twig');
            }
        } else {
            $superAdmin = $this->userRepository->findOneBy(['roles' => 'ROLE_SUPER_ADMIN']);
            $requestedRole = $request->request->get('role');
            if ($requestedRole == 'ROLE_SUPER_ADMIN' && $superAdmin != null) {
                $this->addFlash('danger', 'Le compte ne peut être créé');
                return $this->redirectToRoute('app_base');
            }
            $error = null;
            $result = $this->accountService->createAccount(
                $request,
                $error
            );
            if ($result) {
                $this->addFlash('success', 'Le compte a bien été créé.');
            }
            if ($error) {
                $this->addFlash('error', $error);
            }
            return $this->redirectToRoute('app_base');
        }
    }


    // This function is responsible for rendering the account modifiying interface destined to the super admin
    #[Route(path: '/admin/modify_account/{userid}', name: 'modify_account')]
    public function modify_account(UserInterface $currentUser, int $userid, AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = $this->userRepository->findOneBy(['id' => $userid]);
        if ($request->isMethod('GET')) {
            if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
                $this->addFlash('danger', 'Le compte ne peut être modifié');
                return $this->redirectToRoute('app_base');
            }

            if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
                return $this->render('services/admin_services/accountservices/superadmin_modify_account_view.html.twig', [
                    'user'          => $user,
                    'error'         => $error,
                ]);
            } else {
                return $this->render('services/admin_services/accountservices/modify_account_view.html.twig', [
                    'user'          => $user,
                    'error'         => $error,
                ]);
            }
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
    #[Route(path: '/admin/delete_account/basic{{userId}}', name: 'delete_account_basic')]
    public function delete_account_basic(int $userId): Response
    {
        $result = $this->accountService->deleteUser($userId);
        if ($result) {
            $this->addFlash('success',  'Le compte a été supprimé');
            return $this->redirectToRoute('app_base');
        }
    }
}