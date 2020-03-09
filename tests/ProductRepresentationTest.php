<?php


namespace App\Tests;


use App\Repository\ProductRepository;
use App\Representation\ProductRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\TestCase;

class ProductRepresentationTest extends TestCase
{
    /**
     * @var ProductRepresentation
     */
    private $representation;

    public function setUp()
    {
        $factory = $this->createMock(SerializationContextFactoryInterface::class);
        $arrayTransformer = $this->createMock(ArrayTransformerInterface::class);
        $repo = $this->createMock(ProductRepository::class);
        $pager = $this->createMock(Pagerfanta::class);

        $repo->method('search')
            ->willReturn($pager);

        $pager->method('getCurrentPageResults')
            ->willReturn([]);
        $pager->method('count')
            ->willReturn(100);
        $pager->method('getNbPages')
            ->willReturn(20);

        $this->representation = new ProductRepresentation($factory,$arrayTransformer,$repo);

        return $this->representation;
    }

    public function testPaginatedRepresentation()
    {
        $paginated = $this->representation->paginatedRepresentation(1,5);

        $this->assertInstanceOf(PaginatedRepresentation::class, $paginated);
        $this->assertEquals(1, $paginated->getPage());
    }

}