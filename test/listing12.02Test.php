<?php
namespace test;

/**
 * This class provides any base functionality shared
 * by all tests
 */

use Registry;
use Request;

require_once "PHPUnit/Framework/TestCase.php";

ob_start();
require_once "listing12.02.php";
ob_end_clean();


class listing1202Test extends \PHPUnit_Framework_TestCase
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
        $req = new Request();
        $reg->set("req", $req);
        $req2 = $reg2->get("req", $req);
        $this->assertTrue($req === $req2);
    }
}

?>
