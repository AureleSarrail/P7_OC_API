<?php


namespace App\Service;


use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use App\Validator\CustomerCreationValidator;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @var CustomerCreationValidator
     */
    private $validator;

    /**
     * CustomerCreateService constructor.
     * @param CustomerRepository $customerRepository
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $manager
     * @param CustomerCreationValidator $validator
     */
    public function __construct(
        CustomerRepository $customerRepository,
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        ValidatorInterface $validator
    ) {
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $this->validator = $validator;
    }

    public function customerCreate(UserInterface $user, Customer $customer)
    {

        $errors = $this->validator->validate($customer);

        if (count($errors) > 0) {
            return $errors;
        }
        else {
            $customer->setUser($user)
                ->setCreatedAt(new \DateTime());

            $this->manager->persist($customer);
            $this->manager->flush();

            return $customer;
        }
    }
}