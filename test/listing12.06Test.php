<?php
namespace test;

use woo\base\ApplicationRegistry;
use woo\command\AddVenue;
use woo\command\CommandResolver;
use woo\command\DefaultCommand;
use woo\controller\ApplicationHelper;
use woo\controller\Controller;
use woo\controller\Request;

require_once "PHPUnit/Framework/TestCase.php";

ob_start();
require_once "listing12.06.php";
ob_end_clean();

class listing1206Test extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        ApplicationRegistry::clean();
    }

    function tearDown()
    {
    }

    function testController()
    {
        ob_start();
        Controller::run();
        $output = ob_get_contents();
        ob_end_clean();

        // this tests the feedback from the default command
        $this->assertTrue(preg_match('/Welcome to WOO/si', $output) === 1);

        // this tests the title of the default view 
        $this->assertTrue(preg_match("/Woo! it's WOO!/si", $output) === 1);
    }

    function testApplicationController()
    {
        if (file_exists("data/dsn")) {
            unlink("data/dsn");
        }
        $helper = ApplicationHelper::instance();
        $helper->init();
        $this->assertTrue(!is_null($helper));
        $this->assertEquals(ApplicationRegistry::getDSN(), 'sqlite:./data/woo.db');
        $this->assertTrue(file_exists("data/dsn"));
    }

    function testCommandResolver()
    {
        $resolver = new CommandResolver();
        $request = new Request();
        $cmd = $resolver->getCommand($request);
        $this->assertTrue($cmd instanceof DefaultCommand);

        $request->setProperty("cmd", "AddVenue");
        $cmd = $resolver->getCommand($request);
        $this->assertTrue($cmd instanceof AddVenue);
    }
}

?>
