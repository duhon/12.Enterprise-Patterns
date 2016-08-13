<?php
namespace test;

use woo\base\ApplicationRegistry;
use woo\controller\Controller;

require_once 'PHPUnit/Framework/TestCase.php';

require_once "woo/controller/ApplicationHelper.php";
require_once "woo/controller/Controller.php";
require_once 'woo/base/Registry.php';
require_once 'woo/command/Command.php';

class ControllerTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        ApplicationRegistry::clean();

        // forces rebuild of cache
        if (file_exists('data/dsn')) {
            unlink('data/dsn');
        }
        if (file_exists('data/cmap')) {
            unlink('data/cmap');
        }

    }

    function tearDown()
    {
    }

    function testController()
    {
        $request = ApplicationRegistry::getRequest();
        $request->setProperty('cmd', 'AddVenue');

        ob_start();
        Controller::run();
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertTrue(preg_match('/Add a Venue/si', $output) === 1);

        $request->clearLastCommand();
        $ac = ApplicationRegistry::appController();
        $ac->reset();

        $request->setProperty('venue_name', 'Bob\'s Hat Jive Hut');
        ob_start();
        Controller::run();
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertTrue(preg_match('/Add a Space/si', $output) === 1);
    }
}

?>
