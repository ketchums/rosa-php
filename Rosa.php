<?php declare (strict_types = 1);

namespace Rosa;

class Rosa {
    private $objects = [];

    public function register(object $object) : void {
        $this->objects[get_class($object)] = $object;
    }

    public function fetch(string $objectName) : object {
        if (array_key_exists($objectName, $this->objects)) {
            return $this->objects[$objectName];
        }

        return $this->make($objectName);
    }

    private function make(string $objectName) : object {
        $reflection = new \ReflectionClass($objectName);

        if (!$reflection->isInstantiable()) {
            // @TODO - This object can't be instantiated.
        }

        /*if ($reflection->getConstructor() == null) {
            return $reflection->newInstanceWithoutConstructor();
        }*/

        $arguments = $this->resolveArguments($reflection);

        if (count($arguments) < 1) {
            return $reflection->newInstance();
        }
        else {
            return $reflection->newInstanceArgs($arguments);
        }
    }

    private function resolveArguments($reflection) : array {
        return []; // @TODO - Autowiring?
    }
}