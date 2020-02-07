<?php declare (strict_types = 1);

namespace Rosa;

interface ContainerInterface 
{
    public function register(object $object);
    public function fetch(string $objectName);
}