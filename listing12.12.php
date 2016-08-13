<?php
namespace woo\domain;

abstract class DomainObject
{
    private $id;

    function __construct($id = null)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function collection()
    {
        return self::getCollection(get_class($this));
    }

    static function getCollection($type)
    {
        return array(); // dummy
    }
}

class Venue extends DomainObject
{
    private $name;
    private $spaces;

    function __construct($id = null, $name = null)
    {
        $this->name = $name;
        $this->spaces = self::getCollection("\\woo\\domain\\Space");
        parent::__construct($id);
    }

    function getSpaces()
    {
        return $this->spaces;
    }

    function setSpaces(SpaceCollection $spaces)
    {
        $this->spaces = $spaces;
    }

    function addSpace(Space $space)
    {
        $this->spaces->add($space);
        $space->setVenue($this);
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

$v = new Venue(null, "The grep and grouch");
?>
