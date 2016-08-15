<?php
namespace Registry;

declare(ticks=1);
include 'bootstrap.php';

$registry1 = Registry::instance();
$registry2 = Registry::instance();
print_r($registry2->getRequest());
print_r($registry2->treeBuilder());

// testing the system
Registry::testMode();
$mockReg = Registry::instance();
print_r($mockReg);

Registry::testMode(false);
$registry4 = Registry::instance();
print_r($registry4);

/* OUTPUT
Registry\Request Object()
Registry\TreeBuilder Object()
Registry\MockRegistry Object()
Registry\Registry Object
(
    [request:Registry\Registry:private] =>
    [treeBuilder:Registry\Registry:private] =>
    [conf:Registry\Registry:private] =>
)

*/