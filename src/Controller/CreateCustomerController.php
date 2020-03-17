<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Service\ContextCreationService;
use App\Service\CustomerCreateService;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;
use Swagger\Annotations as SWG;


class CreateCustomerController extends AbstractController
{
    const GROUP = 'customerDetails';

    /**
     * @Route("/customers", name="create_customer", methods={"POST"})
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param CustomerCreateService $service
     * @param ContextCreationService $contextCreation
     * @return JsonResponse
     * @SWG\Response(
     *     response=201,
     *     description="Create a new customer in the api Database",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Customer::class, groups={"customersDetails"}))
     *  )
     * )
     */
    public function index(
        SerializerInterface $serializer,
        Request $request,
        CustomerCreateService $service,
        ContextCreationService $contextCreation
    ) {
        $context = $contextCreation->getContext(self::GROUP);

        $response = $service->customerCreate($this->getUser(),
            $serializer->deserialize($request->getContent(), Customer::class, 'json'));

        if ($response instanceof ConstraintViolationList) {
            $json = $serializer->serialize($response, 'json');

            return new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);
        } else {
            $json = $serializer->serialize($response, 'json', $context);

            return new JsonResponse($json, Response::HTTP_CREATED, [], true);
        }
    }
}
