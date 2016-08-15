<?php
namespace test;

use Registry\Registry;
use Registry\Request;

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

        $request1 = new Request();
        $registry1->set('req', $request1);
        $request2 = $registry2->get('req');
        $this->assertTrue($request1 === $request2);
    }
}
