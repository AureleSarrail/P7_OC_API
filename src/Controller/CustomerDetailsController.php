<?php

namespace App\Controller;

use App\Controller\Exceptions\NoCustomerFoundException;
use App\Repository\CustomerRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerDetailsController extends AbstractController
{
    /**
     * @Route("/customers/{id<\d+>}", name="customer_details", methods={"GET"})
     * @param $id
     * @param CustomerRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws NoCustomerFoundException
     */
    public function index($id, CustomerRepository $repo, SerializerInterface $serializer)
    {
        $customer = $repo->find($id);

        if(empty($customer)) {
            throw new NoCustomerFoundException('Customer not found', 404);
        } else {
            $json = $serializer->serialize($customer, 'json', SerializationContext::create()->setGroups(['Default','customerDetails']));

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
    }
}
