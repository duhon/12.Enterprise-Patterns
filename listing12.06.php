<?php
namespace woo\controller;

require_once("woo/base/Registry.php"); // Registry

class Controller
{
    private $applicationHelper;

    private function __construct()
    {
    }

    static function run()
    {
        $instance = new Controller();
        $instance->init();
        $instance->handleRequest();
    }

    function init()
    {
        $applicationHelper
            = ApplicationHelper::instance();
        $applicationHelper->init();
    }

    function handleRequest()
    {
        $request = \woo\base\ApplicationRegistry::getRequest();
        $cmd_r = new \woo\command\CommandResolver();
        $cmd = $cmd_r->getCommand($request);
        $cmd->execute($request);
    }
}

class ApplicationHelper
{
    private static $instance = null;
    private $config = "data/woo_options.xml";

    private function __construct()
    {
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function init()
    {
        $dsn = \woo\base\ApplicationRegistry::getDSN();
        if (!is_null($dsn)) {
            return;
        }
        $this->getOptions();
    }

    private function getOptions()
    {
        $this->ensure(file_exists($this->config),
            "Could not find options file");
        $options = \simplexml_load_file($this->config);
        $dsn = (string)$options->dsn;
        $this->ensure($dsn, "No DSN found");
        \woo\base\ApplicationRegistry::setDSN($dsn);
    }

    private function ensure($expr, $message)
    {
        if (!$expr) {
            throw new \woo\base\AppException($message);
        }
    }
}

// Registry includes a clashing version of this under woo/controller/Request.php
/*
class Request {
    private $properties;
    private $feedback = array();

    function __construct() {
        $this->init();
    }

    function init() {
        if ( isset( $_SERVER['REQUEST_METHOD'] ) ) {
            $this->properties = $_REQUEST;
            return;
        }
        foreach( $_SERVER['argv'] as $arg ) {
            if ( strpos( $arg, '=' ) ) {
                list( $key, $val )=explode( "=", $arg );
                $this->setProperty( $key, $val );
            }
        }
    }

    function getProperty( $key ) {
        if ( isset( $this->properties[$key] ) ) {
            return $this->properties[$key];
        }
        return null;
    }

    function setProperty( $key, $val ) {
        $this->properties[$key] = $val;
    }
    
    function addFeedback( $msg ) {
        array_push( $this->feedback, $msg );
    }
 
    function getFeedback( ) {
        return $this->feedback;
    }

    function getFeedbackString( $separator="\n" ) {
        return implode( $separator, $this->feedback );
    }
}
*/


namespace woo\command;

abstract class Command
{
    final function __construct()
    {
    }

    function execute(\woo\controller\Request $request)
    {
        $this->doExecute($request);
    }

    abstract function doExecute(\woo\controller\Request $request);
}

class DefaultCommand extends Command
{
    function doExecute(\woo\controller\Request $request)
    {
        $request->addFeedback("Welcome to WOO");
        include("woo/view/main.php");
    }
}

class CommandResolver
{
    private static $base_cmd = null;
    private static $default_cmd = null;

    function __construct()
    {
        if (is_null(self::$base_cmd)) {
            self::$base_cmd = new \ReflectionClass("\woo\command\Command");
            self::$default_cmd = new DefaultCommand();
        }
    }

    function getCommand(\woo\controller\Request $request)
    {
        $cmd = $request->getProperty('cmd');
        $sep = DIRECTORY_SEPARATOR;
        if (!$cmd) {
            return self::$default_cmd;
        }
        $cmd = str_replace(array('.', $sep), "", $cmd);
        $filepath = "woo{$sep}command{$sep}{$cmd}.php";
        $classname = "woo\\command\\{$cmd}";
        if (file_exists($filepath)) {
            require_once($filepath);
            if (class_exists($classname)) {
                $cmd_class = new \ReflectionClass($classname);
                if ($cmd_class->isSubClassOf(self::$base_cmd)) {
                    return $cmd_class->newInstance();
                } else {
                    $request->addFeedback("command '$cmd' is not a Command");
                }
            }
        }
        $request->addFeedback("command '$cmd' not found");
        return clone self::$default_cmd;
    }
}


\woo\controller\Controller::run();

?>
