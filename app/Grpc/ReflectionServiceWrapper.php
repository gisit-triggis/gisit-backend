<?php

namespace App\Grpc;

use App\Grpc\Contracts\ServiceInvoker;
use App\Grpc\Contracts\ServiceWrapper;
use Spiral\RoadRunner\GRPC\ContextInterface;
use Spiral\RoadRunner\GRPC\Exception\NotFoundException;
use Spiral\RoadRunner\GRPC\Exception\ServiceException;
use Spiral\RoadRunner\GRPC\Method;
use Spiral\RoadRunner\GRPC\StatusCode;

class ReflectionServiceWrapper implements ServiceWrapper
{
    /**
     * Service name.
     * 
     * @var     string
     */
    protected $name;

    /**
     * Service's methods
     * 
     * @var     array
     */
    protected $methods = [];

    /**
     * Invoker.
     * 
     * @var     \App\Grpc\Contracts\ServiceInvoker
     */
    protected $invoker;

    /**
     * Fully qualified service interface.
     * 
     * @var     string
     */
    protected $interface;

    /**
     * Create new ServiceWrapper instance.
     * 
     * @param   \App\Grpc\Contracts\ServiceInvoker   $invoker
     * @param   string                               $interface
     */
    public function __construct(
        ServiceInvoker $invoker,
        string $interface
    ) { 
        $this->invoker = $invoker;
        $this->interface = $interface;

        $this->configure($interface);
    }

    /**
     * Retrive service name.
     * 
     * @return  string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieve public methods.
     * 
     * @return  array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Invoke service.
     * 
     * @param string                        $method
     * @param \Spiral\RoadRunner\Grpc\ContextInterface  $context
     * @param string                        $input
     * 
     * @return string
     *
     * @throws \Spiral\RoadRunner\Grpc\Exception\NotFoundException
     * @throws \Spiral\RoadRunner\Grpc\Exception\InvokeException
     */
    public function invoke(string $method, ContextInterface $context, ?string $input): string
    {
        if (!isset($this->methods[$method])) {
            throw new NotFoundException("Method `{$method}` not found in service `{$this->name}`.");
        }

        return $this->invoker->invoke($this->interface, $this->methods[$method], $context, $input);
    }

    /**
     * Configure service name and methods.
     *
     * @param string           $interface
     *
     * @throws \Spiral\RoadRunner\Grpc\Exception\ServiceException
     */
    protected function configure(string $interface)
    {
        try {
            $r = new \ReflectionClass($interface);
            if (!$r->hasConstant('NAME')) {
                throw new ServiceException(
                    "Invalid service interface `{$interface}`, constant `NAME` not found."
                );
            }
            $this->name = $r->getConstant('NAME');
        } catch (\ReflectionException $e) {
            throw new ServiceException(
                "Invalid service interface `{$interface}`.",
                StatusCode::INTERNAL,
                [$e]
            );
        }

        // list of all available methods and their object types
        $this->methods = $this->fetchMethods($interface);
    }

    /**
     * @param \Spiral\RoadRunner\Grpc\ServiceInterface $service
     * 
     * @return array
     */
    protected function fetchMethods(string $interface): array
    {
        $reflection = new \ReflectionClass($interface);

        $methods = [];
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if (Method::match($method)) {
                $methods[$method->getName()] = Method::parse($method);
            }
        }

        return $methods;
    }
}