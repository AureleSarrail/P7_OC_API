<?php


namespace App\Service;


use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerCreateService
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * CustomerCreateService constructor.
     * @param CustomerRepository $customerRepository
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        CustomerRepository $customerRepository,
        UserRepository $userRepository,
        EntityManagerInterface $manager
    ) {
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository;
        $this->manager = $manager;
    }

    public function customerCreate(UserInterface $userInterface, Customer $customer)
    {
        $user = $this->userRepository->findOneBy(['username' => $userInterface->getUsername()]);

        $customer->setCreatedAt(new \DateTime())
            ->setUser($user);

        $this->manager->persist($customer);
        $this->manager->flush();

        return $customer;
    }
}