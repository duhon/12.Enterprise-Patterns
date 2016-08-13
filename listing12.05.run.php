<?php
// put me in a web facing directory
// together with listing12.05.php
// then run in two windows -- confirm that an update in one 
// window is reflected in the other next time it reloads

require_once("listing12.05.php"); // Registry

print "<h1>\woo\base\MemApplicationRegistry</h1>";
$reg = \woo\base\MemApplicationRegistry::instance();
if (is_null($reg->getDSN())) {
    $reg->setDSN(1);
}
print $reg->getDSN();
print "<pre>";
$reg->setDSN($reg->getDSN() + 1);
print "</pre>";

print "<h1>\woo\base\SessionRegistry</h1>";

$reg2 = \woo\base\SessionRegistry::instance();
if (is_null($reg2->getDSN())) {
    $reg2->setDSN(1);
}
print $reg2->getDSN();
print "<pre>";
$reg2->setDSN($reg2->getDSN() + 1);
print "</pre>";


?>
