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
use App\Service\ImCoMeServices;

class FormCreationService extends AbstractController
{
    private $PictureService;
    private $imcomeService;

    private $logger;

    protected $projectDir;

    private $em;

    public function __construct(

        PictureService                              $PictureService,
        ImCoMeService                               $imcomeService,

        LoggerInterface                             $logger,

        ParameterBagInterface                       $params,

        EntityManagerInterface                      $em
    ) {
        $this->PictureService                               = $PictureService;
        $this->imcomeService                                = $imcomeService;

        $this->logger                                       = $logger;

        $this->projectDir                                   = $params->get('kernel.project_dir');

        $this->em                                           = $em;
    }
    public function createNCForm(
        EFNC $efnc,
        Request $request,
        ?FormInterface $form1 = null

    ) {
        $now = new \DateTime();
        $efnc->setCreatedAt($now);
        $this->em->persist($efnc);

        $efncTitle = $this->efncTitleBuilding($efnc);
        $efnc->setTitle($efncTitle);

        $efncFolderName = $form1->get('Project')->getData()->getName() . '.' . $now->format('Y-m-d') . '.' . $efncTitle;

        if ((key_exists('closed', $request->request->all()) == true) && ($request->request->get('closed')) != null) {
            $efnc->setClosed(true);
        };
        // Check if 'picture' key exists and is not null
        if (key_exists('picture', $request->files->all()) && $request->files->get('picture') != null) {
            $pictures = $request->files->all()['picture'];
            // Process TraceabilityPictures
            if (key_exists('TraceabilityPicture', $pictures)) {
                foreach ($pictures['TraceabilityPicture'] as $traceabilityPicture) {
                    $traceabilityPictures[] = $traceabilityPicture;
                }
            }
            // Process NCpictures
            if (key_exists('NCpicture', $pictures)) {
                foreach ($pictures['NCpicture'] as $ncPicture) {
                    $ncPictures[] = $ncPicture;
                }
            }
        }
        // Process each file, e.g., save them to the server
        if (isset($traceabilityPictures)) {
            foreach ($traceabilityPictures as $picture) {
                // Save or process $pictures
                $result = $this->PictureService->pictureUpload($picture, $efnc, $efncFolderName, 'traceability');
            }
        }
        if (isset($ncPictures)) {
            foreach ($ncPictures as $picture) {
                // Save or process $picture
                $result = $this->PictureService->pictureUpload($picture, $efnc, $efncFolderName, 'NC');
            }
        }
        if ($result != true) {
            return false;
        }
        $this->imcomeService->imcomeAssignation($efnc, $form1);
        $this->em->persist($efnc);
        $this->em->flush();
        return true;
    }


    public function efncTitleBuilding(EFNC $efnc)
    {
        $efncTitle = 'FNC' . '_' . $efnc->getDetectionPlace()->getName() . '_' . $efnc->getProject()->getName() . '_' . $efnc->getProduct()->getCategory()->getName() . '_' . $efnc->getProduct()->getVersion()->getName() . '_' . $efnc->getProduct()->getColor()->getName() . '_' . $efnc->getAnomalyType()->getName();
        $this->logger->info('fnc id for title:' . $efnc->getId());
        // return $this->slugify($efncTitle);
        return $efncTitle;
    }
}
