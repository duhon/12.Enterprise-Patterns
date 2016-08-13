<?php
namespace test;

/**
 * This class provides any base functionality shared
 * by all tests
 */

use MockRegistry;
use Registry;

require_once "PHPUnit/Framework/TestCase.php";

ob_start();
require_once "listing12.03.php";
ob_end_clean();


class listing1203Test extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function testRegistry()
    {
        $reg = Registry::instance();
        $reg2 = Registry::instance();
        $this->assertTrue($reg === $reg2);
        $treebuilder1 = $reg->treeBuilder();
        $treebuilder2 = $reg->treeBuilder();
        $this->assertTrue($treebuilder1 === $treebuilder2);

        $req = $reg->getRequest();
        $req2 = $reg2->getRequest($req);
        $this->assertTrue($req === $req2);

        Registry::testMode();
        $reg3 = Registry::instance();
        $reg4 = Registry::instance();
        $this->assertTrue(!($reg === $reg3));
        $this->assertTrue($reg3 === $reg4);
        $this->assertTrue($reg3 instanceof MockRegistry);

        Registry::testMode(false);
        $reg5 = Registry::instance();
        $this->assertTrue($reg5 instanceof Registry);
        $this->assertTrue(!($reg5 instanceof MockRegistry));

    }
}

?>
