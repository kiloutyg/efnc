<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

use App\Repository\UserRepository;

use App\Service\AccountService;

#[Route('/', name: 'app_')]
class AccountController extends AbstractController
{
    private $userRepository;

    private $accountService;

    public function __construct(
        UserRepository $userRepository,

        AccountService $accountService,
    ) {
        $this->userRepository = $userRepository;

        $this->accountService = $accountService;
    }

    #[Route('/createAccount', name: 'create_account')]
    public function createAccount(Request $request): Response
    {
        if ($request->isMethod('GET')) {
            $url = 'services/admin_services/accountservices/create_account.html.twig';
            if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
                $url = 'services/admin_services/accountservices/superadmin_create_account.html.twig';
            }
            return $this->render($url, [
                'users' => $this->userRepository->findAll(),
            ]);
        } else {
            $superAdmin = $this->userRepository->findOneBy(['roles' => 'ROLE_SUPER_ADMIN']);
            $requestedRole = $request->request->get('role');
            if ($requestedRole == 'ROLE_SUPER_ADMIN' && $superAdmin != null) {
                $this->addFlash('danger', 'Le compte ne peut être créé');
            } else {
                try {
                    $result = $this->accountService->createAccount($request);
                    if ($result) {
                        $this->addFlash('success', 'Le compte a bien été créé.');
                    }
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                    $this->addFlash('danger', $error);
                }
            }
            return $this->redirectToRoute('app_base');
        }
    }


    // This function is responsible for rendering the account modifiying interface destined to the super admin
    #[Route(path: '/admin/modify_account/{userid}', name: 'modify_account')]
    public function modifyAccount(UserInterface $currentUser, int $userid, AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $user = $this->userRepository->find($userid);
        if ($request->isMethod('POST')) {
            $error = $authenticationUtils->getLastAuthenticationError();
            $usermod = $this->accountService->modifyAccount($request, $currentUser, $user);
            if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
                $this->addFlash('danger', 'Le compte ne peut être modifié');
            } else if ($usermod instanceof User) {
                $this->addFlash('success', 'Le compte ' . $usermod->getUsername() . ' a été modifié');
            };
            return $this->redirectToRoute('app_base');
        }
        $url = 'services/admin_services/accountservices/modify_account_view.html.twig';
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            $url = 'services/admin_services/accountservices/superadmin_modify_account_view.html.twig';
        }
        return $this->render($url, [
            'user'          => $user,
        ]);
    }


    // This function is responsible for managing the logic of the account deletion
    #[Route(path: '/admin/delete_account/basic{{userId}}', name: 'delete_account_basic')]
    public function delete_account_basic(int $userId): Response
    {
        $result = $this->accountService->deleteUser($userId);
        if ($result) {
            $this->addFlash('success',  'Le compte a été supprimé');
            return $this->redirectToRoute('app_base');
        } else {
            $this->addFlash('warning',  'Le compte n\'a pas été supprimé');
            return $this->redirectToRoute('app_base');
        }
    }
}
