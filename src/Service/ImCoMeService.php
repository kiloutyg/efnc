<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;
use App\Entity\ImmediateConservatoryMeasures;
use App\Entity\ImmediateConservatoryMeasuresList;


class ImCoMeService extends AbstractController
{
    // private $logger;

    private $projectDir;

    private $em;

    public function __construct(
        // LoggerInterface                     $logger,

        ParameterBagInterface               $params,

        EntityManagerInterface              $em
    ) {
        // $this->logger                       = $logger;

        $this->projectDir                   = $params->get('kernel.project_dir');

        $this->em                           = $em;
    }

    public function imcomeAssignation(EFNC $efnc, ImmediateConservatoryMeasures $imcome, FormInterface $imcomeform, Request $request)
    {
        if ($imcomeform->get('action')->getData() === 'Autre (Précisez l\'action prise)') {
            $imcome->setCustomAction($imcomeform->get('customAction')->getData());
        } else {
            $imcome->setCustomAction(null);
        }
        $imcome->setEFNC($efnc);
        $this->em->persist($imcome);
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