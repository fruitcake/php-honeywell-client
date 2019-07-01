<?php


namespace Fruitcake\HoneywellClient\Models;


class Location
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var array
     */
    protected $devices;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return Location
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  int  $id
     *
     * @return Location
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param  array  $devices
     *
     * @return Location
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;

        return $this;
    }




}