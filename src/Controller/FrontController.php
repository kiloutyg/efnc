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

    #[Route('/form_list', name: 'form_list')]
    public function formList(): Response
    {
        return $this->render('/services/efnc/display/efnc_list.html.twig', []);
    }
}