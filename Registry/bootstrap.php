<?php
namespace Registry;

//autoload
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class) . '.php';
    include preg_replace('/^' . __NAMESPACE__ . '/', 'src', $path);
});

//add \n after row
ob_start();
register_tick_function(function(){
    $data = ob_get_contents();
    if (!empty($data) && $data{strlen($data)-1} !== PHP_EOL) {
        echo PHP_EOL;
    }
});
