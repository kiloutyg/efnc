<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Team;

use App\Service\PictureService;

class TeamService extends AbstractController
{
    private $PictureService;

    private $logger;

    protected $projectDir;

    private $em;

    public function __construct(

        PictureService                              $PictureService,

        LoggerInterface                             $logger,

        ParameterBagInterface                       $params,

        EntityManagerInterface                      $em
    ) {
        $this->PictureService                               = $PictureService;

        $this->logger                                       = $logger;

        $this->projectDir                                   = $params->get('kernel.project_dir');

        $this->em                                           = $em;
    }

    public function createTeam(
        Team $team,
        Request $request,
        FormInterface $teamForm
    ) {

        $this->em->persist($team);
        $this->em->flush();
        return true;
    }
}