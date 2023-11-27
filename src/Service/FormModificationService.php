<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// use Psr\Log\LoggerInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;

use App\Service\PictureService;

class FormModificationService extends AbstractController
{
    private $PictureService;

    // private $logger;

    protected $projectDir;

    private $em;

    public function __construct(

        PictureService                              $PictureService,

        // LoggerInterface                             $logger,

        ParameterBagInterface                       $params,

        EntityManagerInterface                      $em
    ) {
        $this->PictureService                               = $PictureService;

        // $this->logger                                       = $logger;

        $this->projectDir                                   = $params->get('kernel.project_dir');

        $this->em                                           = $em;
    }
    public function modifyNCForm(
        EFNC $efnc,
        Request $request,
        FormInterface $form1
    ) {
        $now = new \DateTime();

        $efnc->setUpdatedAt($now);


        $efncFolderName = $form1->get('Project')->getData()->getName() . '.' . $now->format('Y-m-d') . '.' . $efnc->getTitle();

        if ((key_exists('Status', $request->request->all()) == true) && ($request->request->get('Status')) != null) {
            $efnc->setStatus(true);
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
        foreach ($traceabilityPictures as $picture) {
            // Save or process $pictures
            $this->PictureService->pictureUpload($picture, $efnc, $efncFolderName, 'traceability');
        }
        foreach ($ncPictures as $picture) {
            // Save or process $picture
            $this->PictureService->pictureUpload($picture, $efnc, $efncFolderName, 'NC');
        }
        $this->em->persist($efnc);
        $this->em->flush();

        return true;
    }
}