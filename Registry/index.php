<?php
namespace Registry;

declare(ticks=1);
include 'bootstrap.php';

$reg = Registry::instance();
$reg->setRequest(new Request());

$reg = Registry::instance();
print_r($reg->getRequest());

/* OUTPUT
Registry\Request Object
(
)
*/