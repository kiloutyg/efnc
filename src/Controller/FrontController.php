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
        $this->mailerService->sendReminderEmailToAdmin();

        return $this->render('base.html.twig', []);
    }

    #[Route('/form_list', name: 'form_list')]
    public function formList(): Response
    {
        return $this->render('/services/efnc/display/efnc_list.html.twig', []);
    }
    #[Route('/admin/archived_form_list', name: 'archived_form_list')]
    public function archivedFormList(): Response
    {
        return $this->render('/services/efnc/display/archived_efnc_list.html.twig', []);
    }
    #[Route('/admin/closed_form_list', name: 'closed_form_list')]
    public function closedFormList(): Response
    {
        return $this->render('/services/efnc/display/closed_efnc_list.html.twig', []);
    }

    #[Route('/admin/old', name: 'old')]
    public function testForOld(): Response
    {
        $this->mailerService->sendReminderEmailToAdmin();

        return $this->redirectToRoute('app_base');
    }
}
