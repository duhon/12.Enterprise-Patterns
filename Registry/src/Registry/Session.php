<?php
namespace Registry\Registry;

use Registry\Registry;

class Session extends Registry
{
    protected function __construct()
    {
        session_start();
    }

    function getDSN()
    {
        return self::instance()->get('dsn');
    }

    function setDSN($dsn)
    {
        self::instance()->set('dsn', $dsn);
    }

    protected function set($key, $value)
    {
        $_SESSION[__CLASS__][$key] = $value;
    }

    protected function get($key)
    {
        if (isset($_SESSION[__CLASS__][$key])) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }
}
