<?php

namespace Testing\Classes;

class ParentObject {
    private $child;

    public function __construct(ChildObject $child) {
        $this->child = $child;
    }

    public function getChild() {
        return $this->child;
    }
}