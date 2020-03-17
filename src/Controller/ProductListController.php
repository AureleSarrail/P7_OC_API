<?php

namespace App\Controller;

use App\Representation\ProductRepresentation;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class ProductListController extends AbstractController
{
    /**
     * @Route("/products", name="product_list", methods={"GET"})
     * @param SerializerInterface $serializer
     * @param ProductRepresentation $representation
     * @param Request $request
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns a paginated list of available products",
     *     @Model(type=Product::class, groups={"productList"})
     *  )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="The number of the page you want to see"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     description="The number of products you want on one page"
     * )
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

