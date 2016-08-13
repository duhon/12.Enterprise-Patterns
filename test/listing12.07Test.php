<?php
namespace test;

use woo\base\ApplicationRegistry;
use woo\controller\Controller;

require_once "PHPUnit/Framework/TestCase.php";

ob_start();
require_once "listing12.07.php";
ob_end_clean();

class listing1207Test extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        ApplicationRegistry::clean();

        // forces rebuild of cache
        if (file_exists("data/dsn")) {
            unlink("data/dsn");
        }
    }

    function tearDown()
    {
    }

    function testControllerDefault()
    {

        ob_start();
        Controller::run();
        $output = ob_get_contents();
        ob_end_clean();
        // default feedback message
        $this->assertTrue(preg_match('/Welcome to WOO/si', $output) === 1);
        // main.php title
        $this->assertTrue(preg_match("/Woo! it's WOO!/si", $output) === 1);
    }

    function testControllerAddVenue()
    {
        $request = ApplicationRegistry::getRequest();
        $request->setProperty('cmd', 'AddVenue');
        //$request->setProperty( "venue_name", "Bob's Badger Emporium" );

        ob_start();
        Controller::run();
        $output = ob_get_contents();
        ob_end_clean();

        // feedback from command
        $this->assertTrue(preg_match('/no name provided/si', $output) === 1);

        // title of addvenue view
        $this->assertTrue(preg_match('/Add a Venue/si', $output) === 1);
    }
}

?>
