<?php

namespace App\Controller;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerListController extends AbstractController
{
    /**
     * @Route("/customers", name="customer_list")
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index(SerializerInterface $serializer)
    {
        $user = $this->getUser();

        $customers = $user->getCustomers();

        $json = $serializer->serialize($customers, 'json',
            SerializationContext::create()->setGroups(['customersList']));

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
