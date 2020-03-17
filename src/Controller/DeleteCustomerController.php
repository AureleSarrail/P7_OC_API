<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Service\DeleteCustomerService;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class DeleteCustomerController extends AbstractController
{
    /**
     * @Route("/customers/{id<\d+>}", name="delete_customer", methods={"DELETE"})
     * @param Customer $customer
     * @param SerializerInterface $serializer
     * @param DeleteCustomerService $service
     * @return JsonResponse
     * @throws Exceptions\NoCustomerFoundException
     * @IsGranted("CUSTOMER_DELETE", subject="customer")
     * @SWG\Response(
     *     response=200,
     *     description="Delete a customer from the Api Database"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Customer Not Found"
     * )
     */
    public function index(Customer $customer, SerializerInterface $serializer, DeleteCustomerService $service)
    {
        $response = $service->deleteCustomer($customer->getId());

        $json = $serializer->serialize($response, 'json');

        return new JsonResponse($json, 200, [], true);
    }
}
