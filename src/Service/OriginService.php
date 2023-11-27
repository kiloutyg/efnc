<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Origin;


class OriginService extends AbstractController
{
    private $logger;

    private $em;

    public function __construct(

        LoggerInterface                                     $logger,

        EntityManagerInterface                              $em
    ) {
        $this->logger                                       = $logger;

        $this->em                                           = $em;
    }

    public function createOrigin(
        origin $origin,
        Request $request,
        FormInterface $originForm
    ) {

        $this->em->persist($origin);
        $this->em->flush();
        return true;
    }
}