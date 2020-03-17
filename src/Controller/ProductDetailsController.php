<?php

namespace App\Controller;

use App\Controller\Exceptions\NoProductFoundException;
use App\Repository\ProductRepository;
use App\Service\ContextCreationService;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Entity\Product;

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
     * @SWG\Response(
     *     response=200,
     *     description="Returns details of a product",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Product::class, groups={"productDetails"}))
     *  )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Unknown product"
     * )
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
            throw new NoProductFoundException('Unknown Product', 404);
        } else {
            $json = $serializer->serialize($product, 'json', $context);

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
    }
}
