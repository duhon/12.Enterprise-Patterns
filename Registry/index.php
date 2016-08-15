<?php
namespace Registry;

declare(ticks=1);
include 'bootstrap.php';

$registry1 = Registry::instance();
$registry1->set('request', new Request());

$registry2 = Registry::instance();
print_r($registry2->get('request'));

/* OUTPUT
Registry\Request Object
(
)
*/