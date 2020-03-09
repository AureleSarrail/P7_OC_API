<?php

namespace App\Controller;

use App\Controller\Exceptions\NoCustomerFoundException;
use App\Repository\CustomerRepository;
use App\Service\ContextCreationService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerDetailsController extends AbstractController
{

    const GROUP = 'customerDetails';

    /**
     * @Route("/customers/{id<\d+>}", name="customer_details", methods={"GET"})
     * @param $idCustomer
     * @param CustomerRepository $repo
     * @param SerializerInterface $serializer
     * @param ContextCreationService $service
     * @return JsonResponse
     * @throws NoCustomerFoundException
     */
    public function index(
        $idCustomer,
        CustomerRepository $repo,
        SerializerInterface $serializer,
        ContextCreationService $service
    ) {
        $context = $service->getContext(self::GROUP);
        $customer = $repo->find($idCustomer);

        if (empty($customer)) {
            throw new NoCustomerFoundException('Customer not found', 404);
        } else {
            $json = $serializer->serialize($customer, 'json', $context);

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
    }
}
