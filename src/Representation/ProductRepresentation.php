<?php


namespace App\Representation;


use App\Repository\ProductRepository;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;

class ProductRepresentation
{
    const MAX_PER_PAGE = 5;
    /**
     * @var ArrayTransformerInterface
     */
    private $arrayTransformer;
    /**
     * @var ProductRepository
     */
    private $repo;

    public function __construct(ArrayTransformerInterface $arrayTransformer, ProductRepository $repo)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->repo = $repo;
    }

    public function paginatedRepresentation($page, $limit)
    {
        $pager = $this->repo->search($page, $limit);

        $normalized = $this->arrayTransformer->toArray($pager->getCurrentPageResults(),
            SerializationContext::create()->setGroups('productList'));

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