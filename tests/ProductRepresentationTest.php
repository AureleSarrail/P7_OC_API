<?php


namespace App\Tests;


use App\Repository\ProductRepository;
use App\Representation\ProductRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use PHPUnit\Framework\TestCase;

class ProductRepresentationTest extends TestCase
{
    /**
     * @var ProductRepresentation
     */
    private $productRepresentation;

    public function setUp()
    {
        $factory = $this->createMock(SerializationContextFactoryInterface::class);
        $arrayTransformer = $this->createMock(ArrayTransformerInterface::class);
        $repo = $this->createMock(ProductRepository::class);

        $this->productRepresentation = new ProductRepresentation($factory,$arrayTransformer,$repo);

        return $this->productRepresentation;
    }

    public function testPaginatedRepresentation()
    {
//        $paginated = $this->productRepresentation->paginatedRepresentation(1,5);

//        $this->assertInstanceOf(PaginatedRepresentation::class, $paginated);
    }

}