<?php
namespace Registry\Registry;

use Registry\Registry;
use Registry\Request as RequestContext;

class Request extends Registry
{
    private $values = [];

    protected function get($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    static function getRequest()
    {
        $inst = self::instance();
        if (is_null($inst->get('request'))) {
            $inst->set('request', new RequestContext());
        }
        return $inst->get('request');
    }
}