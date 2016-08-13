<?php
namespace woo\domain;

require_once("woo/domain/DomainObject.php");

class Space extends DomainObject
{
    private $name;
    private $events;
    private $venue;

    function __construct($id = null, $name = 'main')
    {
        parent::__construct($id);
        //$this->events = self::getCollection("woo\\domain\\Event");
        $this->events = null;
        $this->name = $name;
    }

    function getEvents()
    {
        if (is_null($this->events)) {
            $this->events = self::getFinder('woo\\domain\\Event')
                ->findBySpaceId($this->getId());
        }
        return $this->events;
    }

    function setEvents(EventCollection $events)
    {
        $this->events = $events;
    }

    function addEvent(Event $event)
    {
        $this->events->add($event);
        $event->setSpace($this);
    }

    function getVenue()
    {
        return $this->venue;
    }

    function setVenue(Venue $venue)
    {
        $this->venue = $venue;
        $this->markDirty();
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name_s)
    {
        $this->name = $name_s;
        $this->markDirty();
    }
}

?>
