<?php

namespace App\Controller;

use App\Representation\ProductRepresentation;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductListController extends AbstractController
{
    /**
     * @Route("/products", name="product_list")
     * @param SerializerInterface $serializer
     * @param ProductRepresentation $representation
     * @param Request $request
     * @return JsonResponse
     */
    public function index(
        SerializerInterface $serializer,
        ProductRepresentation $representation,
        Request $request
    ): Response {

        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 5);

        $paginatedCollection = $representation->paginatedRepresentation($page, $limit);

        $json = $serializer->serialize($paginatedCollection, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}

