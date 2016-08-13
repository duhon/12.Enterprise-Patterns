<?php
namespace test;

use woo\base\ApplicationRegistry;
use woo\base\MemApplicationRegistry;
use woo\base\RequestRegistry;

require_once "PHPUnit/Framework/TestCase.php";

ob_start();
require_once "listing12.05.php";
ob_end_clean();

class listing1205Test extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function testRequestRegistry()
    {

        $reg = RequestRegistry::instance();
        $reg2 = RequestRegistry::instance();
        $this->assertTrue($reg === $reg2);

        $reg3 = ApplicationRegistry::instance();
        $reg4 = ApplicationRegistry::instance();
        $this->assertTrue($reg3 === $reg4);

        $reg3->setDSN("aaaa");
        $dsn = $reg4->getDSN();
        $this->assertEquals($dsn, "aaaa");

        // have another process write
        print system('php test/sub.listing12.05.appreg.php');

        // confirm update
        $dsn = $reg4->getDSN();
        $this->assertEquals($dsn, "4444");


        $reg5 = MemApplicationRegistry::instance();
        $reg6 = MemApplicationRegistry::instance();
        $this->assertTrue($reg5 === $reg6);

        //$reg7 = \woo\base\SessionRegistry::instance();
        //$reg8 = \woo\base\SessionRegistry::instance();
        //$this->assertTrue( $reg7=== $reg8 );

    }
}

?>
