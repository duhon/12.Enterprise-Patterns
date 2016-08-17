<?php
namespace test;

use Registry\Registry\Application;
use Registry\Registry\Memory;
use Registry\Registry\Request;
use Registry\Registry\Session;

/**
 * This class provides any base functionality shared
 * by all tests
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{
    function testRequest()
    {
        $reg1 = Request::instance();
        $reg2 = Request::instance();
        $this->assertTrue($reg1 === $reg2);
    }

    function testMemory()
    {
        $reg5 = Memory::instance();
        $reg6 = Memory::instance();
        $this->assertTrue($reg5 === $reg6);
    }

    function testApplication()
    {
        $reg3 = Application::instance();
        $reg4 = Application::instance();
        $this->assertTrue($reg3 === $reg4);

        $reg3->setDSN('aaaa');
        $this->assertEquals($reg4->getDSN(), 'aaaa');

        // have another process write
        sleep(1);
        `php -r "include 'bootstrap.php'; \Registry\Registry\Application::instance()->setDsn(4444);"`;

        // confirm update
        $this->assertEquals($reg4->getDSN(), '4444');
    }

    public function testSession()
    {
        $reg7 = Session::instance();
        $reg8 = Session::instance();
        $this->assertTrue($reg7 === $reg8);
    }
}
