<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use App\Repository\EFNCRepository;

use App\Service\MailerService;
use App\Service\EntityDeletionService;

#[Route('/', name: 'app_')]
class FrontController extends AbstractController
{
    private $userRepository;
    private $eFNCRepository;
    private $mailerService;
    private $entityDeletionService;

    public function __construct(
        UserRepository $userRepository,
        EFNCRepository $eFNCRepository,
        MailerService $mailerService,

        EntityDeletionService $entityDeletionService
    ) {
        $this->userRepository = $userRepository;
        $this->eFNCRepository = $eFNCRepository;
        $this->mailerService = $mailerService;

        $this->entityDeletionService = $entityDeletionService;
    }

    #[Route('/', name: 'base')]
    public function base(): Response
    {
        if (count($this->eFNCRepository->getMonthOldLowLevelRiskEfnc()) > 0) {
            $this->mailerService->sendReminderEmailToAdmin();
        }
        return $this->render('base.html.twig', [
            'EFNCs'                 => $this->eFNCRepository->findAll(),
        ]);
    }

    #[Route('/form_list', name: 'form_list')]
    public function formList(): Response
    {
        return $this->render('/services/efnc/display/efnc_list.html.twig', [
            'EFNCs'                 => $this->eFNCRepository->findAll(),
        ]);
    }
    #[Route('/admin/archived_form_list', name: 'archived_form_list')]
    public function archivedFormList(): Response
    {
        return $this->render('/services/efnc/display/archived_efnc_list.html.twig', [
            'EFNCs'                 => $this->eFNCRepository->findAll(),
        ]);
    }
    #[Route('/admin/closed_form_list', name: 'closed_form_list')]
    public function closedFormList(): Response
    {
        return $this->render('/services/efnc/display/closed_efnc_list.html.twig', [
            'EFNCs'                 => $this->eFNCRepository->findAll(),
        ]);
    }

    #[Route('/admin/statusflag', name: 'status_flag')]
    public function statusFlagUpdate(): Response
    {
        foreach ($this->eFNCRepository->findAll() as $eFNC) {
            $this->entityDeletionService->setStatusFlag($eFNC);
        }
        $this->addFlash('success', 'status_flag has been updated');
        return $this->redirectToRoute('app_base');
    }
}
