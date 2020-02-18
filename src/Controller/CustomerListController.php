<?php

namespace App\Controller;

use App\Repository\UserRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerListController extends AbstractController
{
    /**
     * @Route("{id<\d+>}/customers", name="customer_list")
     * @param $id
     * @param UserRepository $repo
     * @return JsonResponse
     */
    public function index($id, UserRepository $repo, SerializerInterface $serializer)
    {
        $user = $repo->find($id);

        $customers = $user->getCustomers();

        $json = $serializer->serialize($customers, 'json', SerializationContext::create()->setGroups(['customersList']));

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
