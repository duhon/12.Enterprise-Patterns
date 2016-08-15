<?php
namespace test;

use Registry\Registry;

/**
 * This class provides any base functionality shared
 * by all tests
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{
    function testRegistry()
    {
        $registry1 = Registry::instance();
        $registry2 = Registry::instance();
        $this->assertTrue($registry1 === $registry2);

        $request1 = $registry1->getRequest();
        $request2 = $registry2->getRequest();
        $this->assertTrue($request1 === $request2);
    }
}
