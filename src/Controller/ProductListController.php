<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductListController extends AbstractController
{
    /**
     * @Route("/products", name="product_list")
     * @param ProductRepository $repo
     * @return JsonResponse
     */
    public function index(ProductRepository $repo, SerializerInterface $serializer): Response
    {
        $json = $serializer->serialize($repo->findAll(), 'json', SerializationContext::create()->setGroups(['productList']));

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}

