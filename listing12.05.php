<?php
namespace woo\base;

abstract class Registry
{
    abstract protected function get($key);

    abstract protected function set($key, $val);
}

class RequestRegistry extends Registry
{
    private static $instance = null;
    private $values = array();

    private function __construct()
    {
    }

    static function getRequest()
    {
        $inst = self::instance();
        if (is_null($inst->get("request"))) {
            $inst->set('request', new \woo\controller\Request());
        }
        return $inst->get("request");
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set($key, $val)
    {
        $this->values[$key] = $val;
    }
}

class SessionRegistry extends Registry
{
    private static $instance = null;

    private function __construct()
    {
        session_start();
    }

    function setDSN($dsn)
    {
        self::instance()->set('dsn', $dsn);
    }

    protected function set($key, $val)
    {
        $_SESSION[__CLASS__][$key] = $val;
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function getDSN()
    {
        return self::instance()->get("dsn");
    }

    protected function get($key)
    {
        if (isset($_SESSION[__CLASS__][$key])) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }
}

class ApplicationRegistry extends Registry
{
    private static $instance = null;
    private $freezedir = "data";
    private $values = array();
    private $mtimes = array();
    private $request = null;

    private function __construct()
    {
    }

    static function clean()
    {
        self::$instance = null;
    }

    static function getDSN()
    {
        return self::instance()->get('dsn');
    }

    protected function get($key)
    {
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
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

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    static function setDSN($dsn)
    {
        return self::instance()->set('dsn', $dsn);
    }

    protected function set($key, $val)
    {
        $this->values[$key] = $val;
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        file_put_contents($path, serialize($val));
        $this->mtimes[$key] = time();
    }

    static function getRequest()
    {
        $inst = self::instance();
        if (is_null($inst->request)) {
            $inst->request = new \woo\controller\Request();
        }
        return $inst->request;
    }

}

class MemApplicationRegistry extends Registry
{
    private static $instance = null;
    private $values = array();
    private $id;

    private function __construct()
    {
    }

    static function getDSN()
    {
        return self::instance()->get("dsn");
    }

    protected function get($key)
    {
        return \apc_fetch($key);
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    static function setDSN($dsn)
    {
        return self::instance()->set("dsn", $dsn);
    }

    protected function set($key, $val)
    {
        return \apc_store($key, $val);
    }

}

?>
