<?php


namespace Fruitcake\Honeywell\Models;


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
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return Location
     */
    public function setName(string $name) : Location
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param  int  $id
     *
     * @return Location
     */
    public function setId(int $id) : Location
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function getDevices() : array
    {
        return $this->devices;
    }

    /**
     * @param  array  $devices
     *
     * @return Location
     */
    public function setDevices(array $devices) : Location
    {
        $this->devices = $devices;

        return $this;
    }




}