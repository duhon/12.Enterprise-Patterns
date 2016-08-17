<?php
namespace Registry\Registry;

use Registry\Registry;

class Memory extends Registry
{
    private $id;

    protected function __construct()
    {
        $this->id = shmop_open(0xff3, "c", 0644, 100);
        $data = shmop_read($this->id, 0, shmop_size($this->id));
        if ($data == '') {
            shmop_write($this->id, serialize([]), 0);
        }
    }

    static function getDSN()
    {
        return self::instance()->get('dsn');
    }

    static function setDSN($dsn)
    {
        return self::instance()->set('dsn', $dsn);
    }

    protected function get($key)
    {
        $storage = unserialize(shmop_read($this->id, 0, shmop_size($this->id)));
        return isset($storage[$key]) ? $storage[$key] : null;
    }

    protected function set($key, $value)
    {
        $storage = unserialize(shmop_read($this->id, 0, shmop_size($this->id)));
        $storage[$key] = $value;
        return shmop_write($this->id, serialize($storage), 0);
    }
}
