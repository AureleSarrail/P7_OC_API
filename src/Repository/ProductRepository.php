<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AbstractRepository
{
    const MAX_PER_PAGE = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function search($page,$limit = self::MAX_PER_PAGE){
        $builder = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'asc');

        return $this->paginate($builder,$limit,$page);
    }

    public function getSearchQuery($page){

        return $this->createQueryBuilder('p')
            ->setMaxResults(self::MAX_PER_PAGE)
            ->setFirstResult(($page-1) * self::MAX_PER_PAGE)
            ->orderBy('p.id', 'asc')
            ->getQuery();
    }
}
