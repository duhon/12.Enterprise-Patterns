<?php
namespace Registry\Registry;

use Registry\Registry;
use Registry\Request;

class Application extends Registry
{
    private $freezeDir = 'data';
    private $values = [];
    private $mtimes = [];
    private $request = null;

    static function getDSN()
    {
        return self::instance()->get('dsn');
    }

    static function setDSN($dsn)
    {
        self::instance()->set('dsn', $dsn);
    }

    protected function get($key)
    {
        $path = $this->freezeDir . DIRECTORY_SEPARATOR . $key;
        if (file_exists($path)) {
            clearstatcache();
            $mtime = filemtime($path);
            if (!isset($this->mtimes[$key])) {
                $this->mtimes[$key] = 0;
            }
            if ($mtime > $this->mtimes[$key]) {
                $data = file_get_contents($path);
                $this->mtimes[$key] = $mtime;
                return ($this->values[$key] = unserialize($data));
            }
        }
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set($key, $value)
    {
        $this->values[$key] = $value;
        $path = $this->freezeDir . DIRECTORY_SEPARATOR . $key;
        file_put_contents($path, serialize($value));
        $this->mtimes[$key] = time();
    }

    static function getRequest()
    {
        $inst = self::instance();
        if (is_null($inst->request)) {
            $inst->request = new Request();
        }
        return $inst->request;
    }
}
