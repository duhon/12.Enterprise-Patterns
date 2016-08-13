<?php
namespace test;

/**
 * This class provides any base functionality shared
 * by all tests
 */

use Registry;

require_once 'PHPUnit/Framework/TestCase.php';

ob_start();
require_once 'listing12.01.php';
ob_end_clean();


class listing1201Test extends \PHPUnit_Framework_TestCase
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

        $req = $reg->getRequest();
        $req2 = $reg2->getRequest();
        $this->assertTrue($req === $req2);
    }
}

?>
