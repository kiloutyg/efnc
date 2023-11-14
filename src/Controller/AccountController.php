<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Controller\FrontController;


#[Route('/', name: 'app_')]
class AccountController extends FrontController
{
    #[Route('/createAccount', name: 'create_account')]
    public function createAccount(Request $request): Response
    {
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
            $this->addFlash('success', 'Le compte de Super-Administrateur a bien été créé.');
        }
        if ($error) {
            $this->addFlash('error', $error);
        }


        return $this->redirectToRoute('app_base');
    }
}