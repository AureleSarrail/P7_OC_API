<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerDetailsController extends AbstractController
{
    /**
     * @Route("/customer/{id<\d+>}", name="customer_details")
     * @param $id
     * @param CustomerRepository $repo
     * @return JsonResponse
     */
    public function index($id, CustomerRepository $repo)
    {
        $customer = $repo->find($id);

        return $this->json($customer, Response::HTTP_OK, [], ['groups' => 'customerDetails']);
    }
}
