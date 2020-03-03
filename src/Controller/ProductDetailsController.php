<?php

namespace App\Controller;

use App\Controller\Exceptions\NoProductFoundException;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductDetailsController extends AbstractController
{
    /**
     * @Route("/products/{id<\d+>}", name="product_details", methods={"GET"})
     * @param $id
     * @param ProductRepository $repo
     * @param SerializerInterface $serializer
     * @return Response
     * @throws NoProductFoundException
     */
    public function index($id, ProductRepository $repo, SerializerInterface $serializer): Response
    {
        $product = $repo->find($id);

        if(empty($product)) {
            throw new NoProductFoundException('Le produit est inconnu !', 404);
        } else {
            $json = $serializer->serialize($product, 'json', SerializationContext::create()->setGroups(['productDetails']));

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
    }
}
