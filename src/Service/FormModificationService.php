<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;

use App\Service\PictureService;

class FormModificationService extends AbstractController
{
    private $pictureService;

    private $logger;
    protected $projectDir;
    private $em;
    public function __construct(

        PictureService                              $pictureService,

        LoggerInterface                             $logger,
        ParameterBagInterface                       $params,
        EntityManagerInterface                      $em
    ) {
        $this->pictureService                       = $pictureService;

        $this->logger                               = $logger;
        $this->projectDir                           = $params->get('kernel.project_dir');
        $this->em                                   = $em;
    }
    public function modifyNCForm(
        EFNC $efnc,
        Request $request,
        FormInterface $form1,
    ) {
        $now = new \DateTime();
        $efnc->setUpdatedAt($now);
        $efncFolderName = $form1->get('Project')->getData()->getName() . '.' . $now->format('Y-m-d') . '.' . $efnc->getTitle();

        try {
            $this->pictureService->formPictureManager($request, $efnc, $efncFolderName);
        } catch (\Exception $e) {
            $this->logger->error('error in pictureService modifyNCForm', [$e->getMessage()]);
            return false;
        }
        $efnc->setLastModifier($this->getUser()->getUsername());
        $this->em->persist($efnc);
        $this->em->flush();

        return true;
    }
}
