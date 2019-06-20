<?php


namespace Fruitcake\Honeywell;

use Fruitcake\Honeywell\Models\Device;
use Fruitcake\Honeywell\Models\HoneywellAccessCredentials;
use Fruitcake\Honeywell\Models\Location;
use Fruitcake\Honeywell\Traits\AuthenticatesClient;
use Fruitcake\Honeywell\Traits\CreatesRequests;
use GuzzleHttp\Client;


class HoneywellClient
{
    use AuthenticatesClient, CreatesRequests;

    /**
     * @var string
     */
    protected $baseUrl = 'https://api.honeywell.com/';

    /**
     * HoneywellClient constructor.
     *
     * @param  Client  $httpClient
     * @param  string  $redirectUri
     * @param  string  $consumerKey
     * @param  string  $consumerSecret
     */
    public function __construct(
        $redirectUri,
        $consumerKey,
        $consumerSecret,
        HoneywellAccessCredentials $accessCredentials = null,
        Client $httpClient = null
    ) {
        $this->redirectUri = $redirectUri;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->httpClient = $httpClient ?? new Client();
        $this->accessCredentials = $accessCredentials ?? new HoneywellAccessCredentials();
    }

    /**
     * @return array
     */
    public function getLocations() : array
    {
        $locations = [];
        foreach ($this->request('v2/locations') as $location) {
            $model = new Location();
            $model->setName($location->name);
            $model->setId($location->locationID);
            $devices = [];

            foreach ($location->devices as $device) {
                $deviceModel = new Device();
                $deviceModel->setId($device->deviceID);
                $deviceModel->setName($device->userDefinedDeviceName);
                $deviceModel->setIndoorTemperature($device->indoorTemperature);
                $deviceModel->setOutdoorTemperature($device->outdoorTemperature);
                $deviceModel->setHumidity($device->displayedOutdoorHumidity);

                $devices[] = $deviceModel;
            }

            $model->setDevices($devices);

            $locations[] = $model;
        }

        return $locations;
    }

    public function changeTemperature(Device $device, Location $location, float $toTemperature)
    {
        $device = $this->request('v2/devices/thermostats/'.$device->getId(), [
            "mode" => "Cool",
            "heatSetpoint" => $toTemperature,
            "coolSetpoint" => $toTemperature,
            'AutoChangeoverActive' => true,
        ], ['locationId' => $location->getId()]);

        $deviceModel = new Device();
        $deviceModel->setId($device->deviceID);
        $deviceModel->setName($device->userDefinedDeviceName);
        $deviceModel->setIndoorTemperature($device->indoorTemperature);
        $deviceModel->setOutdoorTemperature($device->outdoorTemperature);
        $deviceModel->setHumidity($device->displayedOutdoorHumidity);
        dd($deviceModel, $device);
    }

}