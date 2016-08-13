<?php

class Registry
{
    private static $instance = null;
    private static $testmode = false;
    private $request = null;
    private $treeBuilder = null;
    private $conf = null;

    private function __construct()
    {
    }

    static function testMode($mode = true)
    {
        self::$instance = null;
        self::$testmode = $mode;
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            if (self::$testmode) {
                self::$instance = new MockRegistry();
            } else {
                self::$instance = new self();
            }
        }
        return self::$instance;
    }

    function getRequest()
    {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }

    function treeBuilder()
    {
        if (is_null($this->treeBuilder)) {
            $this->treeBuilder = new TreeBuilder($this->conf()->get('treedir'));
        }
        return $this->treeBuilder;
    }

    function conf()
    {
        if (is_null($this->conf)) {
            $this->conf = new Conf();
        }
        return $this->conf;
    }
}

class Conf
{
    function get()
    {
    }
}

class TreeBuilder
{
}

class MockRegistry
{

}

// empty class for testing
class Request
{
}

$reg = Registry::instance();
$reg2 = Registry::instance();
print_r($reg2->getRequest());
print_r($reg2->treeBuilder());

// testing the system
Registry::testMode();
$mockreg = Registry::instance();


print_r($mockreg);
Registry::testMode(false);
$reg4 = Registry::instance();
print_r($reg4);
?>
