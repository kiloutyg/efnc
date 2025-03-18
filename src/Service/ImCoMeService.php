<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;
use App\Entity\ImmediateConservatoryMeasuresList;


class ImCoMeService extends AbstractController
{
    private $em;

    public function __construct(
        EntityManagerInterface              $em,
    ) {
        $this->em                           = $em;

    }

    public function imcomeAssignation(
        EFNC $efnc,
        FormInterface $efncform,
    ) {
        foreach ($efncform->get('immediateConservatoryMeasures')->getData() as $imcome) {

            $imcome->setEFNC($efnc);
            $this->em->persist($imcome);
        }
        $this->em->persist($efnc);
        $this->em->flush();
        return true;
    }


    public function imcomeListCreation(
        ImmediateConservatoryMeasuresList $imcomeList)
    {
        $this->em->persist($imcomeList);
        $this->em->flush();
        return true;
    }
}