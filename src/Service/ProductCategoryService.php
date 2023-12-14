<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\ProductCategory;


class ProductCategoryService extends AbstractController
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

    public function createProductCategory(
        ProductCategory $productCategory,
        Request $request,
        FormInterface $productCategoryForm
    ) {

        $this->em->persist($productCategory);
        $this->em->flush();
        return true;
    }
}