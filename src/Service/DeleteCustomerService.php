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
    private $em;

    /**
     * DeleteCustomerService constructor.
     * @param CustomerRepository $repo
     * @param EntityManagerInterface $em
     */
    public function __construct(CustomerRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @param $id
     * @return array
     * @throws NoCustomerFoundException
     */
    public function deleteCustomer($id)
    {
        $customer = $this->repo->find($id);

        if (!empty($customer)) {
            $this->em->remove($customer);
            $this->em->flush();

            $response = [
                'message' => 'Customer deleted with success'
            ];

            return $response;
        } else {
            throw new NoCustomerFoundException("This customer don\'t exist");
        }

    }
}