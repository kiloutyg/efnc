<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;
use App\Entity\ImmediatePreventiveActionPlan;
use App\Entity\Picture;


use App\Repository\EFNCRepository;
use App\Repository\CorrectivePreventiveActionPlanRepository;
use App\Repository\PictureRepository;
use App\Repository\ImmediateConservatoryMeasuresRepository;
use App\Repository\AnomalyTypeRepository;



class FormCreationService
{
    private $efncRepository;
    private $correctivePreventiveActionPlanRepository;
    private $pictureRepository;
    private $immediateConservatoryMeasuresRepository;
    private $anomalyTypeRepository;

    private $logger;

    private $params;
    // private $file;

    private $em;

    public function __construct(
        EFNCRepository                              $efncRepository,
        CorrectivePreventiveActionPlanRepository    $correctivePreventiveActionPlanRepository,
        PictureRepository                           $pictureRepository,
        ImmediateConservatoryMeasuresRepository     $immediateConservatoryMeasuresRepository,
        AnomalyTypeRepository                       $anomalyTypeRepository,

        LoggerInterface                             $logger,

        ParameterBagInterface                       $params,
        // File                                        $file,

        EntityManagerInterface                      $em
    ) {
        $this->efncRepository                               = $efncRepository;
        $this->correctivePreventiveActionPlanRepository     = $correctivePreventiveActionPlanRepository;
        $this->pictureRepository                            = $pictureRepository;
        $this->immediateConservatoryMeasuresRepository      = $immediateConservatoryMeasuresRepository;
        $this->anomalyTypeRepository                        = $anomalyTypeRepository;

        $this->logger                                       = $logger;

        $this->params                                       = $params;
        // $this->file                                         = $file;

        $this->em                                           = $em;
    }
    public function createForm(EFNC $efnc, Request $request, FormInterface $form)
    {
        $this->logger->info('full request and form data passed in the request just to see: ' . json_encode($request->request->all()));

        $now = new \DateTime();
        $this->logger->info('Current DateTime: ' . $now->format('Y-m-d H:i:s'));
        $efnc->setCreatedAt($now);

        $efncFolderName = $now->format('Y-m-d H:i:s') . '_' . $form->get('Title') . '_' . $form->get('Project');
        $this->logger->info('EFNC Folder Name: ' . $efncFolderName);

        // if ((key_exists('status', $request->request->all()) != true) && ($request->request->get('status') != true)) {
        //     $efnc->setStatus(false);
        // };
        if ($form->get('status')->getData() != true) {
            $efnc->setStatus(false);
        };

        // if ((key_exists('TraceabilityPicture', $request->request->all()) == true) && ($request->request->get('TraceabilityPicture')) != null) {
        //     $traceabilityPictures = $request->request->all('TraceabilityPicture');
        // };

        $traceabilityPictures = $form->get('TraceabilityPicture')->getData();
        $ncPictures = $form->get('NCpicture')->getData();

        // Process each file, e.g., save them to the server
        foreach ($traceabilityPictures as $picture) {
            // Save or process $pictures
            $result = $this->pictureUpload($picture);
            if ($result === true) {
                $efnc->addPicture($picture);
            }
        }

        foreach ($ncPictures as $picture) {
            // Save or process $picture
            if ($result === true) {
                $efnc->addPicture($picture);
            }
        }
        $this->em->persist($efnc);
        $this->em->flush();

        return true;
    }

    public function pictureUpload(File $picture)
    {
        $picture = new Picture();


        return true;
    }
}