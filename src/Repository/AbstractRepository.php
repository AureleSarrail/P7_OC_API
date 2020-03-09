<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 10, $page = 1)
    {
        if (0 == $limit || 0 == $page) {
            throw new \LogicException('$limit & $offset must be greater than 0');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setMaxPerPage((int)$limit);
        $pager->setCurrentPage($page);

        return $pager;
    }
}