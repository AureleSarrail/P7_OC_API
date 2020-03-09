<?php

namespace App\Service;

use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ContextCreationService
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var SerializationContextFactoryInterface
     */
    private $factory;

    /**
     * ContextCreationService constructor.
     * @param RequestStack $requestStack
     * @param SerializationContextFactoryInterface $factory
     */
    public function __construct(RequestStack $requestStack, SerializationContextFactoryInterface $factory)
    {
        $this->requestStack = $requestStack;
        $this->factory = $factory;
    }

    public function getContext(string $string)
    {
        $context = $this->factory->createSerializationContext();
        $context->setGroups($string)
            ->setVersion($this->requestStack->getCurrentRequest()->get('version'));

        return $context;
    }
}