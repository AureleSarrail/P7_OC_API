<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Service\CustomerCreateService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;

class CreateCustomerController extends AbstractController
{
    /**
     * @Route("/customers", name="create_customer", methods={"POST"})
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param CustomerCreateService $service
     * @return JsonResponse
     */
    public function index(SerializerInterface $serializer, Request $request, CustomerCreateService $service)
    {
        $response = $service->customerCreate($this->getUser(),
            $serializer->deserialize($request->getContent(), Customer::class, 'json'));

        if ($response instanceof ConstraintViolationList) {
            $json = $serializer->serialize($response, 'json');

            return new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);
        }
        else {
            $json = $serializer->serialize($response, 'json', SerializationContext::create()->setGroups('customerDetails'));

            return new JsonResponse($json, Response::HTTP_CREATED, [], true);
        }
    }
}
