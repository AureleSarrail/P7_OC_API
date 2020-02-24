<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ProductDetailsController extends AbstractController
{
    /**
     * @Route("/products/{id<\d+>}", name="product_details")
     * @param $id
     * @param ProductRepository $repo
     * @return Response
     */
    public function index($id, ProductRepository $repo, SerializerInterface $serializer): Response
    {
        $product = $repo->find($id);

        if(empty($product)) {
            throw new ResourceNotFoundException('Le produit est inconnu !', 404);
        } else {
            $json = $serializer->serialize($product, 'json', SerializationContext::create()->setGroups(['productDetails']));

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
    }
}
