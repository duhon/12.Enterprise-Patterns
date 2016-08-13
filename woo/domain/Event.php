<?php
namespace woo\domain;

require_once("woo/domain/DomainObject.php");

class Event extends DomainObject
{
    private $start;
    private $duration;
    private $name;
    private $space;

    function __construct($id = null, $name = "unknown")
    {
        parent::__construct($id);
        $this->name = $name;
    }

    function getStart()
    {
        return $this->start;
    }

    function setStart($start_l)
    {
        $this->start = $start_l;
    }

    function getSpace()
    {
        return $this->space;
    }

    function setSpace(Space $space)
    {
        $this->space = $space;
        $this->markDirty();
    }

    function getDuration()
    {
        return $this->duration;
    }

    function setDuration($duration_i)
    {
        $this->duration = $duration_i;
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
