<?php


namespace App\Representation;


use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerRepresentation
{

    const GROUP = 'customersList';
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
    /**
     * @var RequestStack
     */
    private $requestStack;


    /**
     * CustomerRepresentation constructor.
     * @param CustomerRepository $customerRepo
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializationContextFactoryInterface $factory
     * @param UserRepository $userRepo
     * @param RequestStack $requestStack
     */
    public function __construct(
        CustomerRepository $customerRepo,
        ArrayTransformerInterface $arrayTransformer,
        SerializationContextFactoryInterface $factory,
        UserRepository $userRepo,
        RequestStack $requestStack
    ) {
        $this->customerRepo = $customerRepo;
        $this->arrayTransformer = $arrayTransformer;
        $this->requestStack = $requestStack;
        $this->context = $factory->createSerializationContext();
        $this->context->setGroups(self::GROUP);
        $this->context->setVersion($requestStack->getCurrentRequest()->get('version'));
        $this->userRepo = $userRepo;
    }

    public function paginatedRepresentation(UserInterface $userInterface, $page, $limit)
    {
//        dd($this->context);

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