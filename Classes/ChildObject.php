<?php


namespace Testing\Classes;


class ChildObject
{
    private $name;

    public function __construct($name = 'Jerry')
    {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}