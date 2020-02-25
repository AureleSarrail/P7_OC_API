<?php

namespace App\Controller;

use App\Representation\CustomerRepresentation;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerListController extends AbstractController
{
    /**
     * @Route("/customers", name="customer_list")
     * @param SerializerInterface $serializer
     * @param CustomerRepresentation $representation
     * @param Request $request
     * @return JsonResponse
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
