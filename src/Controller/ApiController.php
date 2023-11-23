<?php

namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

# This controller is responsible for fetching data from the database and returning it as JSON

class ApiController extends FrontController
{
    #[Route('/api/projects', name: 'api_projects')]
    public function getData(): JsonResponse
    {
        // Fetch entity categories data to let the cascading dropdown access it

        $zones = array_map(function ($zone) {
            return [
                'id'    => $zone->getId(),
                'name'  => $zone->getName(),
                'sortOrder' => $zone->getSortOrder()
            ];
        }, $this->zones);

        $productLines = array_map(function ($productLine) {
            return [
                'id'        => $productLine->getId(),
                'name'      => $productLine->getName(),
                'zone_id'   => $productLine->getZone()->getId(),
                'sortOrder' => $productLine->getSortOrder()
            ];
        }, $this->productLines);

        $categories = array_map(function ($category) {
            return [
                'id'                => $category->getId(),
                'name'              => $category->getName(),
                'product_line_id'   => $category->getProductLine()->getId(),
                'sortOrder'         => $category->getSortOrder()
            ];
        }, $this->categories);

        $buttons = array_map(function ($button) {
            return [
                'id'            => $button->getId(),
                'name'          => $button->getName(),
                'category_id'   => $button->getCategory()->getId(),
                'sortOrder'     => $button->getSortOrder()
            ];
        }, $this->buttons);

        $responseData = [
            'zones'         => $zones,
            'productLines'  => $productLines,
            'categories'    => $categories,
            'buttons'       => $buttons,
        ];

        return new JsonResponse($responseData);
    }
}