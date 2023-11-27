<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\AnomalyType;


class AnomalyTypeService extends AbstractController
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

    public function createAnomalyType(
        AnomalyType $AnomalyType,
        Request $request,
        FormInterface $AnomalyForm
    ) {

        $this->em->persist($AnomalyType);
        $this->em->flush();
        return true;
    }
}