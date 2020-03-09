<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends AbstractRepository
{
    const MAX_PER_PAGE = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function search($idCustomer,$page,$limit = self::MAX_PER_PAGE)
    {
        $builder = $this->createQueryBuilder('c')
            ->where('c.user = :id')
            ->setParameter('id', $idCustomer)
            ->orderBy('c.id', 'asc');

        return $this->paginate($builder,$limit,$page);
    }
}
