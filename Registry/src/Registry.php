<?php
namespace Registry;

class Registry
{
    private static $instance;
    private $request;

    private function __construct()
    {
    }

    static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
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

    function setRequest(Request $request)
    {
        $this->request = $request;
    }
}