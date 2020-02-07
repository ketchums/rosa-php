<?php declare (strict_types = 1);

namespace Rosa;

use RuntimeException;

class Container extends ContainerInterface {
    private $objects = [];

    /**
     * Register an instantiated object to the container.
     *
     * @param object $object
     */
    public function register(object $object) : void {
        $this->objects[get_class($object)] = $object;
    }

    /**
     * Fetch a cached object from the container.
     *
     * @param string $objectName
     * @return object
     */
    public function fetch(string $objectName) : object {
        if (array_key_exists($objectName, $this->objects)) {
            return $this->objects[$objectName];
        }

        $object = $this->make($objectName);

        $this->objects[$objectName] = $object;

        return $object;                                                                                                                                                                                                                                         
    }

    /**
     * Creates an object from its name and auto-wires constructor arguments.
     *
     * @param string $objectName
     * @return object
     * @throws \ReflectionException
     */
    private function make(string $objectName) : object {
        $reflection = new \ReflectionClass($objectName);

        if (!$reflection->isInstantiable()) {
            throw new RuntimeException($reflection->getName() . ' can\'t be instantiated.');
        }

        $arguments = $this->resolveArguments($reflection);

        if (count($arguments) < 1) {
            return $reflection->newInstance();
        }
        else {
            return $reflection->newInstanceArgs($arguments);
        }
    }

    /**
     * Creates an array of arguments from a reflection class.
     * Uses default value if there is one, auto-wires the object if not.
     *
     * @param $reflection
     * @return array
     */
    private function resolveArguments($reflection) : array {
        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return $reflection->newInstance();
        }

        $arguments = [];

        foreach ($parameters as $parameter) {
            if ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
                continue;
            }

            if ($parameter->getClass() == null) {
                exit($parameter->name . ' on ' . $reflection->getName() . ' needs a default value');
            }

            $arguments[] = $this->fetch($parameter->getClass()->getName());
        }

        return $arguments;
    }
}