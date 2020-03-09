<?php

namespace App\Controller;

use App\Controller\Exceptions\NoProductFoundException;
use App\Repository\ProductRepository;
use App\Service\ContextCreationService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductDetailsController extends AbstractController
{
    const GROUP = 'productDetails';

    /**
     * @Route("/products/{id<\d+>}", name="product_details", methods={"GET"})
     * @param $id
     * @param ProductRepository $repo
     * @param SerializerInterface $serializer
     * @param ContextCreationService $service
     * @return Response
     * @throws NoProductFoundException
     */
    public function index(
        $id,
        ProductRepository $repo,
        SerializerInterface $serializer,
        ContextCreationService $service
    ): Response {
        $context = $service->getContext(self::GROUP);
        $product = $repo->find($id);

        if (empty($product)) {
            throw new NoProductFoundException('Le produit est inconnu !', 404);
        } else {
            $json = $serializer->serialize($product, 'json', $context);

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
    }
}
