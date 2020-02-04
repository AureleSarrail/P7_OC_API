<?php

namespace App\Controller;

use App\Repository\ProductRepository;
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
    public function index(ProductRepository $repo): Response
    {
        return $this->json($repo->findAll(),Response::HTTP_OK, [], [
            'groups' => ['productList']
        ]);
    }
}
