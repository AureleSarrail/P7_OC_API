<?php

namespace App\Service;

use App\Controller\Exceptions\NoCustomerFoundException;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCustomerService
{
    /**
     * @var CustomerRepository
     */
    private $repo;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * DeleteCustomerService constructor.
     * @param CustomerRepository $repo
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CustomerRepository $repo, EntityManagerInterface $entityManager)
    {
        $this->repo = $repo;
        $this->manager = $entityManager;
    }

    /**
     * @param $idCustomer
     * @return array
     * @throws NoCustomerFoundException
     */
    public function deleteCustomer($idCustomer)
    {
        $customer = $this->repo->find($idCustomer);

        if (!empty($customer)) {
            $this->manager->remove($customer);
            $this->manager->flush();

            $response = [
                'message' => 'Customer deleted with success'
            ];

            return $response;
        } else {
            throw new NoCustomerFoundException("This customer don\'t exist");
        }

    }
}