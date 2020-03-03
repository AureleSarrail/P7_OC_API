<?php

namespace App\Controller;

use App\Service\DeleteCustomerService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCustomerController extends AbstractController
{
    /**
     * @Route("/customers/{id<\d+>}", name="delete_customer", methods={"DELETE"})
     * @param $id
     * @param SerializerInterface $serializer
     * @param DeleteCustomerService $service
     * @return JsonResponse
     * @throws Exceptions\NoCustomerFoundException
     */
    public function index($id,  SerializerInterface $serializer, DeleteCustomerService $service)
    {

        $response = $service->deleteCustomer($id);

        $json = $serializer->serialize($response, 'json');

        return new JsonResponse($json, 200, [], true);

    }
}
