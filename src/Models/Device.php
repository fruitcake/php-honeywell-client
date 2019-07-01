<?php


namespace Fruitcake\HoneywellClient\Models;


class Device
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var bool
     */
    protected $online;

    /**
     * @var string
     */
    protected $modeUntil;

    /**
     * @var string
     */
    protected $units;

    /**
     * @var int
     */
    protected $humidity;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $scheduledTemperature;

    /**
     * @var int
     */
    protected $indoorTemperature;

    /**
     * @var int
     */
    protected $outdoorTemperature;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  string  $id
     *
     * @return Device
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * @return string
     */
    public function getModeUntil()
    {
        return $this->modeUntil;
    }

    /**
     * @param  string  $modeUntil
     *
     * @return Device
     */
    public function setModeUntil($modeUntil)
    {
        $this->modeUntil = $modeUntil;

        return $this;
    }

    /**
     * @param  int  $humidity
     *
     * @return Device
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;

        return $this;
    }

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
     * @return Device
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getIndoorTemperature()
    {
        return $this->indoorTemperature;
    }

    /**
     * @param  int  $indoorTemperature
     *
     * @return Device
     */
    public function setIndoorTemperature($indoorTemperature)
    {
        $this->indoorTemperature = $indoorTemperature;

        return $this;
    }

    /**
     * @return int
     */
    public function getOutdoorTemperature()
    {
        return $this->outdoorTemperature;
    }

    /**
     * @param  int  $outdoorTemperature
     *
     * @return Device
     */
    public function setOutdoorTemperature($outdoorTemperature)
    {
        $this->outdoorTemperature = $outdoorTemperature;

        return $this;
    }

    /**
     * @return string
     */
    public function getModel() : string
    {
        return $this->model;
    }

    /**
     * @param  string  $model
     *
     * @return Device
     */
    public function setModel(string $model) : Device
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return float
     */
    public function getScheduledTemperature() : float
    {
        return $this->scheduledTemperature;
    }

    /**
     * @param  float  $scheduledTemperature
     *
     * @return Device
     */
    public function setScheduledTemperature(float $scheduledTemperature) : Device
    {
        $this->scheduledTemperature = $scheduledTemperature;

        return $this;
    }

    /**
     * @return string
     */
    public function getMode() : string
    {
        return $this->mode;
    }

    /**
     * @param  string  $mode
     *
     * @return Device
     */
    public function setMode(string $mode) : Device
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOnline() : bool
    {
        return $this->online;
    }

    /**
     * @param  bool  $online
     *
     * @return Device
     */
    public function setOnline(bool $online) : Device
    {
        $this->online = $online;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnits() : string
    {
        return $this->units;
    }

    /**
     * @param  string  $units
     *
     * @return Device
     */
    public function setUnits(string $units) : Device
    {
        $this->units = $units;

        return $this;
    }




}