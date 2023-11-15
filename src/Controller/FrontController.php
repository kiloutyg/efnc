<?php

namespace App\Controller;

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
    public function formCreation(): Response
    {
        return $this->render('services/efnc/creation/form_creation.html.twig', []);
    }
}