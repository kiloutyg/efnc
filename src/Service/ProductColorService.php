<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\ProductColor;


class ProductColorService extends AbstractController
{
    private $logger;

    private $em;

    public function __construct(

        LoggerInterface                             $logger,

        EntityManagerInterface                      $em
    ) {
        $this->logger                                       = $logger;

        $this->em                                           = $em;
    }

    public function createProductColor(
        ProductColor $productColor,
        Request $request,
        FormInterface $productColorForm
    ) {

        $this->em->persist($productColor);
        $this->em->flush();
        return true;
    }
}