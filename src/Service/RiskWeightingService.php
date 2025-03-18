<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;
use App\Entity\RiskWeighting;


class RiskWeightingService extends AbstractController
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

    public function riskWeightingAssignation(FormInterface $form)
    {

        

    }
}