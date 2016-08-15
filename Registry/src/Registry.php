<?php
namespace Registry;

class Registry
{
    private static $instance;
    private $values = [];

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

    function get($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    function set($key, $value)
    {
        $this->values[$key] = $value;
    }
}