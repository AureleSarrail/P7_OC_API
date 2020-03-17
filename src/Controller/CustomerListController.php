<?php

namespace App\Controller;

use App\Representation\CustomerRepresentation;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Entity\Customer;

class CustomerListController extends AbstractController
{
    /**
     * @Route("/customers", name="customer_list", methods={"GET"})
     * @param SerializerInterface $serializer
     * @param CustomerRepresentation $representation
     * @param Request $request
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns a paginated list of your customers",
     *     @Model(type=Customer::class, groups={"customersList"})
     *  )
     * )
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
    public function index(SerializerInterface $serializer, CustomerRepresentation $representation, Request $request)
    {
        $user = $this->getUser();

        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 5);

        $customers = $representation->paginatedRepresentation($user, $page, $limit);

        $json = $serializer->serialize($customers, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
