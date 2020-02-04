<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductDetailsController extends AbstractController
{
    /**
     * @Route("/product/{id<\d+>}", name="product_details")
     * @param $id
     * @param ProductRepository $repo
     * @return Response
     */
    public function index($id, ProductRepository $repo): Response
    {

        $product = $repo->find($id);

        return $this->json($product, Response::HTTP_OK, [], [
            'groups' => ['productDetails']
        ]);
    }
}
