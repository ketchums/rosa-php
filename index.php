<?php declare (strict_types = 1);

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'Rosa.php';
$rosa = new Rosa\Rosa();

include 'Classes/ParentObject.php';
include 'Classes/ChildObject.php';

$rosa->register(new \Testing\Classes\ChildObject());

$parent = $rosa->fetch('Testing\Classes\ParentObject');

echo $parent->getChild()->getName();