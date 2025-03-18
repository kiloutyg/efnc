<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;

use App\Service\PictureService;
use App\Service\ImCoMeService;

class FormCreationService extends AbstractController
{
    private $pictureService;
    private $imcomeService;

    private $logger;
    protected $projectDir;
    private $em;

    public function __construct(

        PictureService                              $pictureService,
        ImCoMeService                               $imcomeService,

        LoggerInterface                             $logger,
        ParameterBagInterface                       $params,
        EntityManagerInterface                      $em
    ) {
        $this->pictureService                               = $pictureService;
        $this->imcomeService                                = $imcomeService;

        $this->logger                                       = $logger;
        $this->projectDir                                   = $params->get('kernel.project_dir');
        $this->em                                           = $em;
    }
    public function createNCForm(
        EFNC $efnc,
        Request $request,
        FormInterface $form1
    ): bool {
        $now = new \DateTime();
        $efnc->setCreatedAt($now);
        $this->em->persist($efnc);

        $efncTitle = $this->efncTitleBuilding($efnc);
        $efnc->setTitle($efncTitle);

        $efncFolderName = $form1->get('Project')->getData()->getName() . '.' . $now->format('Y-m-d') . '.' . $efncTitle;

        try {
            $this->pictureService->formPictureManager($request, $efnc, $efncFolderName);
        } catch (\Exception $e) {
            $this->logger->error('error ', [$e->getMessage()]);
            return false;
        }

        $this->imcomeService->imcomeAssignation($efnc, $form1);
        $efnc->setStatus('open');
        $this->em->persist($efnc);
        $this->em->flush();
        return true;
    }


    public function efncTitleBuilding(EFNC $efnc)
    {
        return 'FNC' . '_' . $efnc->getDetectionPlace()->getName() . '_' . $efnc->getProject()->getName() . '_' . $efnc->getProduct()->getCategory()->getName() . '_' . $efnc->getProduct()->getVersion()->getName() . '_' . $efnc->getProduct()->getColor()->getName() . '_' . $efnc->getAnomalyType()->getName();
    }
}
