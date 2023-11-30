<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;
use App\Entity\ImmediateConservatoryMeasures;
use App\Entity\ImmediateConservatoryMeasuresList;

use App\Repository\ImmediateConservatoryMeasuresListRepository;

class ImCoMeService extends AbstractController
{
    private $logger;

    private $projectDir;

    private $em;

    private $imcomeListRepo;

    public function __construct(
        LoggerInterface                     $logger,

        ParameterBagInterface               $params,

        EntityManagerInterface              $em,

        ImmediateConservatoryMeasuresListRepository $imcomeListRepo
    ) {
        $this->logger                       = $logger;

        $this->projectDir                   = $params->get('kernel.project_dir');

        $this->em                           = $em;

        $this->imcomeListRepo               = $imcomeListRepo;
    }

    public function imcomeAssignation(
        EFNC $efnc,
        // ImmediateConservatoryMeasures $imcome,
        FormInterface $efncform,
        // Request $request
    ) {
        foreach ($efncform->get('immediateConservatoryMeasures')->getData() as $imcome) {
            if ($imcome->getAction() === $this->imcomeListRepo->findOneBy(['name' => 'Autre (Précisez l\'action prise)'])) {
            } else {
                $imcome->setCustomAction(null);
            }
            $imcome->setEFNC($efnc);
            $this->em->persist($imcome);
        }
        $this->em->persist($efnc);
        $this->em->flush();
        return true;
    }


    public function imcomeListCreation(ImmediateConservatoryMeasuresList $imcomeList, Request $request, FormInterface $imcomeform)
    {
        $this->em->persist($imcomeList);
        $this->em->flush();
        return true;
    }
}