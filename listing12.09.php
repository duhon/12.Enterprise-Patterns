<?php
namespace woo\controller;

require_once("woo/base/Registry.php");
require_once("woo/controller/Request.php");
require_once("woo/domain/Venue.php");

/*
// you can add to the Request object via the command line
//
php listing12.09.php cmd=AddVenue venue_name=blah submitted=1
*/

abstract class PageController
{
    abstract function process();

    function forward($resource)
    {
        include($resource);
        exit(0);
    }

    function getRequest()
    {
        return \woo\base\ApplicationRegistry::getRequest();
    }
}

class AddVenueController extends PageController
{
    function process()
    {
        try {
            $request = $this->getRequest();
            $name = $request->getProperty('venue_name');
            if (is_null($request->getProperty('submitted'))) {
                $request->addFeedback("choose a name for the venue");
                $this->forward('add_venue.php');
            } else {
                if (is_null($name)) {
                    $request->addFeedback("name is a required field");
                    $this->forward('add_venue.php');
                }
            }

            $venue = new \woo\domain\Venue(null, $name);
            // add to database

            //$this->forward( "ListVenues.php" );
            $this->forward("listing12.08.php");
        } catch (Exception $e) {
            $this->forward('error.php');
        }
    }
}

$controller = new AddVenueController();
$controller->process();
?>
