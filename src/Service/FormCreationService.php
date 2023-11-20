<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
    public function createForm(EFNC $efnc, Request $request)
    {
        $this->logger->info('full request and form data passed in the request just to see: ' . json_encode($request->request->all()));

        $efnc->setCreatedAt(new \DateTime());

        $this->em->persist($efnc);
        $this->em->flush();

        return true;
    }
}