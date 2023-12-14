<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;


class MailerController extends FrontController

{
    #[Route('/mailer/{id}', name: 'app_mailer')]
    public function mailTemplateTester(int $id)
    {
        $EFNC = $this->EFNCRepository->findOneBy(['id' => $id]);
        $this->mailerService->notificationEmail($EFNC);
        return $this->redirectToRoute('app_base');
    }
}