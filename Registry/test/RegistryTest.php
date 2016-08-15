<?php
namespace test;

use Registry\MockRegistry;
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

        $treeBuilder1 = $registry1->treeBuilder();
        $treeBuilder2 = $registry1->treeBuilder();
        $this->assertTrue($treeBuilder1 === $treeBuilder2);

        Registry::testMode();
        $registry3 = Registry::instance();
        $registry4 = Registry::instance();
        $this->assertTrue(!($registry1 === $registry3));
        $this->assertTrue($registry3 === $registry4);
        $this->assertTrue($registry3 instanceof MockRegistry);

        Registry::testMode(false);
        $registry5 = Registry::instance();
        $this->assertTrue($registry5 instanceof Registry);
        $this->assertTrue(!($registry5 instanceof MockRegistry));

    }
}
