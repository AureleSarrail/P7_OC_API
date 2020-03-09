<?php

namespace App\Representation;

use App\Repository\ProductRepository;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductRepresentation
{
    const MAX_PER_PAGE = 5;
    const GROUP = 'productList';
    /**
     * @var ArrayTransformerInterface
     */
    private $arrayTransformer;
    /**
     * @var ProductRepository
     */
    private $repo;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * ProductRepresentation constructor.
     * @param SerializationContextFactoryInterface $factory
     * @param ArrayTransformerInterface $arrayTransformer
     * @param ProductRepository $repo
     * @param RequestStack $requestStack
     */
    public function __construct(
        SerializationContextFactoryInterface $factory,
        ArrayTransformerInterface $arrayTransformer,
        ProductRepository $repo,
        RequestStack $requestStack
    ) {
        $this->arrayTransformer = $arrayTransformer;
        $this->requestStack = $requestStack;
        $this->context = $factory->createSerializationContext();
        $this->context->setGroups(self::GROUP)
            ->setVersion($requestStack->getCurrentRequest()->get('version'));
        $this->repo = $repo;

    }

    public function paginatedRepresentation($page, $limit)
    {
        $pager = $this->repo->search($page, $limit);

        $normalized = $this->arrayTransformer->toArray($pager->getCurrentPageResults(),
            $this->context);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation($normalized),
            'product_list', // route
            array(), // route parameters
            $page,       // page number
            ProductRepository::MAX_PER_PAGE,      // limit
            $pager->getNbPages(),       // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            true,   // generate relative URIs, optional, defaults to `false`
            $pager->count()       // total collection size, optional, defaults to `null`
        );

        return $paginatedCollection;
    }
}