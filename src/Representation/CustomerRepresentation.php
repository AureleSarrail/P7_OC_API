<?php


namespace App\Representation;


use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerRepresentation
{

    /**
     * @var CustomerRepository
     */
    private $customerRepo;
    /**
     * @var ArrayTransformerInterface
     */
    private $arrayTransformer;
    /**
     * @var UserRepository
     */
    private $userRepo;


    public function __construct(
        CustomerRepository $customerRepo,
        ArrayTransformerInterface $arrayTransformer,
        SerializationContextFactoryInterface $factory,
        UserRepository $userRepo
    ) {
        $this->customerRepo = $customerRepo;
        $this->arrayTransformer = $arrayTransformer;
        $this->context = $factory->createSerializationContext();
        $this->context->setGroups('customersList');
        $this->userRepo = $userRepo;
    }

    public function paginatedRepresentation(UserInterface $userInterface, $page, $limit)
    {
        $username = $userInterface->getUsername();
        $user = $this->userRepo->findOneBy(['username' => $username]);

        $id = $user->getId();
        $pager = $this->customerRepo->search($id, $page, $limit);

        $normalized = $this->arrayTransformer->toArray($pager->getCurrentPageResults(), $this->context);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation($normalized),
            'customer_list', // route
            array(), // route parameters
            $page,       // page number
            CustomerRepository::MAX_PER_PAGE,      // limit
            $pager->getNbPages(),       // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            true,   // generate relative URIs, optional, defaults to `false`
            $pager->count()       // total collection size, optional, defaults to `null`
        );

        return $paginatedCollection;

    }
}