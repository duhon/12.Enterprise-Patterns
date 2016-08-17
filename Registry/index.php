<?php
namespace Registry;

declare(ticks=1);
include 'bootstrap.php';

print 'Registry\Memory';
$memory = Registry\Memory::instance();
if (is_null($memory->getDSN())) {
    $memory->setDSN(1);
}
print $memory->getDSN();
$memory->setDSN($memory->getDSN() + 1);

print 'Registry\Application';
$application = Registry\Application::instance();
if (is_null($application->getDSN())) {
    $application->setDSN(1);
}
print $application->getDSN();
$application->setDSN($application->getDSN() + 1);

/* OUTPUT FIRST RUN
Registry\Memory
1
Registry\Application
1
*/
/* OUTPUT SECOND RUN
Registry\Memory
2
Registry\Application
2
*/