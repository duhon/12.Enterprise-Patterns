<?php
namespace Registry;

abstract class Registry
{
    private static $instance = [];

    protected function __construct()
    {
    }

    static function instance()
    {
        if (!isset(self::$instance[static::class])) {
            self::$instance[static::class] = new static();
        }
        return self::$instance[static::class];
    }

    abstract protected function get($key);

    abstract protected function set($key, $value);
}