<?php

namespace App\Controller;

use App\Entity\EFNC;

use App\Form\FormCreationType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'app_')]
class FrontController extends BaseController
{
    #[Route('/', name: 'base')]
    public function base(): Response
    {
        return $this->render('base.html.twig', []);
    }

    #[Route('/form_creation', name: 'form_creation')]
    public function formCreation(Request $request): Response
    {
        $efnc = new EFNC();
        $form = $this->createForm(FormCreationType::class, $efnc);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $this->formCreationService->createForm($efnc, $form, $request);
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirectToRoute('app_base', []);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirectToRoute('app_base', []);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/efnc/creation/form_creation.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/admin_page', name: 'admin_page')]
    public function adminPage(): Response
    {
        return $this->render('admin_page.html.twig', []);
    }
}