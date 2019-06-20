<?php


namespace Fruitcake\Honeywell\Models;


class Device
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $humidity;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $indoorTemperature;

    /**
     * @var int
     */
    protected $outdoorTemperature;

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @param  string  $id
     *
     * @return Device
     */
    public function setId(string $id) : Device
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getHumidity() : int
    {
        return $this->humidity;
    }

    /**
     * @param  int  $humidity
     *
     * @return Device
     */
    public function setHumidity(int $humidity) : Device
    {
        $this->humidity = $humidity;

        return $this;
    }

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
     * @return Device
     */
    public function setName(string $name) : Device
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getIndoorTemperature() : int
    {
        return $this->indoorTemperature;
    }

    /**
     * @param  int  $indoorTemperature
     *
     * @return Device
     */
    public function setIndoorTemperature(int $indoorTemperature) : Device
    {
        $this->indoorTemperature = $indoorTemperature;

        return $this;
    }

    /**
     * @return int
     */
    public function getOutdoorTemperature() : int
    {
        return $this->outdoorTemperature;
    }

    /**
     * @param  int  $outdoorTemperature
     *
     * @return Device
     */
    public function setOutdoorTemperature(int $outdoorTemperature) : Device
    {
        $this->outdoorTemperature = $outdoorTemperature;

        return $this;
    }



}