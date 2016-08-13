<?php
namespace woo\controller {

    // woo\controller\ApplicationHelper
    use woo\base\AppException;

    class ApplicationHelper
    {
        function getOptions()
        {
            if (!file_exists('data/woo_options_not_there.xml')) {
                throw new AppException(
                    'Could not find options file');
            }
            $options = simplexml_load_file('data/woo_options.xml');
            $dsn = (string)$options->dsn;
            // what do we do with this now?
            // ...
        }
    }

}

namespace woo\base {

    class AppException extends \Exception
    {
    }
}
