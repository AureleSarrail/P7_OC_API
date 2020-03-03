<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCustomerController extends AbstractController
{
    /**
     * @Route("/customers/{id<\d+>}", name="delete_customer", methods={"DELETE"})
     * @param $id
     * @param CustomerRepository $repo
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index($id, CustomerRepository $repo, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $customer = $repo->find($id);
        if (!empty($customer)) {
            $em->remove($customer);
            $em->flush();

            $response = [
                'message' => 'Customer have been deleted'
            ];

            $json = $serializer->serialize($response, 'json');

            return new JsonResponse($json, 200, [], true);
        } else {
            $response = [
                'message' => 'This customer don\'t exist'
            ];

            $json = $serializer->serialize($response, 'json');

            return new JsonResponse($json, 400, [], true);
        }
    }
}
