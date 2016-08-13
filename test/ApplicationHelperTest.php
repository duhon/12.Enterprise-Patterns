<?php
namespace test;

use woo\base\ApplicationRegistry;
use woo\command\AddSpace;
use woo\command\AddVenue;
use woo\command\Command;
use woo\command\DefaultCommand;
use woo\controller\AppController;
use woo\controller\ApplicationHelper;
use woo\controller\ControllerMap;

require_once "PHPUnit/Framework/TestCase.php";

require_once "woo/controller/ApplicationHelper.php";
require_once "woo/base/Registry.php";
require_once "woo/command/Command.php";

class ApplicationHelperTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        ApplicationRegistry::clean();

        // forces rebuild of cache
        if (file_exists("data/dsn")) {
            unlink("data/dsn");
        }
        if (file_exists("data/cmap")) {
            unlink("data/cmap");
        }

    }

    function tearDown()
    {
    }

    function testController()
    {
        $controllermap = ApplicationRegistry::getControllerMap();
        $this->assertTrue(is_null($controllermap));
        $helper = ApplicationHelper::instance();
        $helper->init();
        $controllermap = ApplicationRegistry::getControllerMap();
        $this->assertTrue($controllermap instanceof ControllerMap);

        $this->assertEquals($controllermap->getView('default', 0), "main");
        $this->assertEquals($controllermap->getView('default', Command::statuses("CMD_OK")), "main");
        $this->assertEquals($controllermap->getView('default', Command::statuses("CMD_ERROR")), "error");
        $this->assertEquals($controllermap->getView('QuickAddVenue', 0), "quickadd");
        $this->assertEquals($controllermap->getView('AddVenue', 0), "addvenue");


        $ac = new AppController($controllermap);
        $cmd = new MockCommand();
        $request = ApplicationRegistry::getRequest();

        // with nothing
        $this->assertTrue($ac->getCommand($request) instanceof DefaultCommand);

        // QuickAddVenue / CMD_ERROR
        $request->setProperty("cmd", "QuickAddVenue");
        $cmd->setMockStatus(Command::statuses("CMD_ERROR"));

        // we get the command BEFORE it's run (unless there's a forward)
        $this->assertTrue($ac->getCommand($request) instanceof AddVenue);

        $cmd->execute($request);
        $this->assertEquals($ac->getView($request), "quickadd");

        // AddVenue / CMD_OK
        $request->setProperty("cmd", "AddVenue");
        $cmd->setMockStatus(Command::statuses("CMD_OK"));

        $request->clearLastCommand();
        $ac->reset();
        $this->assertTrue($ac->getCommand($request) instanceof AddVenue);
        $cmd->execute($request);
        $this->assertEquals($ac->getView($request), "addvenue");

        // before running it's AddSpace -- ready for next invocation
        $this->assertTrue($ac->getCommand($request) instanceof AddSpace);

        // AddVenue / CMD_ERROR
        $request->setProperty("cmd", "AddVenue");
        $cmd->setMockStatus(Command::statuses("CMD_ERROR"));

        $cmd->execute($request);
        $this->assertTrue(is_null($ac->getCommand($request)));
    }
}

class MockCommand extends Command
{
    private $mockstatus;

    function doExecute(\woo\controller\Request $request)
    {
        return $this->mockstatus;
    }

    function setMockStatus($mockstatus)
    {
        $this->mockstatus = $mockstatus;
    }
}
/*
<control>
    <view>main</view>
    <view status="CMD_OK">main</view>
    <view status="CMD_ERROR">error</view>

    <command name="ListVenues">
        <view>listvenues</view>
    </command>

    <command name="QuickAddVenue">
        <classalias name="AddVenue" />
        <view>quickadd</view>
    </command>

    <command name="AddVenue">
        <view>addvenue</view>
        <status value="CMD_OK"> 
          <forward>AddSpace</forward>
          <!--<forward>AddVenue</forward> -->
        </status>
    </command>

    <command name="AddSpace">
        <view>addspace</view>
        <status value="CMD_OK"> 
            <forward>ListVenues</forward>
        </status>
    </command>
</control>
*/
