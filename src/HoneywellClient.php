<?php


namespace Fruitcake\HoneywellClient;

use Fruitcake\HoneywellClient\Models\Device;
use Fruitcake\HoneywellClient\Models\HoneywellAccessCredentials;
use Fruitcake\HoneywellClient\Models\Location;
use Fruitcake\HoneywellClient\Traits\AuthenticatesClient;
use Fruitcake\HoneywellClient\Traits\CreatesRequests;
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
        $this->httpClient = $httpClient ?? new Client([
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
        $this->accessCredentials = $accessCredentials ?? new HoneywellAccessCredentials();
    }

    /**
     * @return array
     */
    public function getLocationsAndDevices() : array
    {
        $locations = [];
        foreach ($this->request('v2/locations', 'GET') as $location) {
            $model = new Location();
            $model->setName($location->name);
            $model->setId($location->locationID);
            $devices = [];

            foreach ($location->devices as $device) {
                $deviceModel = $this->responseToDevice($device);

                $devices[] = $deviceModel;
            }

            $model->setDevices($devices);

            $locations[] = $model;
        }

        return $locations;
    }

    /**
     * @param $location
     *
     * @return array
     */
    public function getDevices($location)
    {
        $locationId = $location;
        if ($location instanceof Location) {
            $locationId = $location->getId();
        }

        return array_map([$this, 'responseToDevice'], $this->request('v2/devices', 'GET', [], [
            'locationId' => $locationId,
        ]));
    }

    public function getDevice($location, $device)
    {
        $deviceId = $device;
        if ($device instanceof Device) {
            $deviceId = $device->getId();
        }

        $locationId = $location;
        if ($location instanceof Location) {
            $locationId = $location->getId();
        }

        return collect($this->getDevices($locationId))->where('id', $deviceId)->first();
    }

    /**
     * @param  string|Device  $device
     * @param  string|Location  $location
     * @param  float  $toTemperature
     * @param  bool  $temporary
     *
     * @return Device
     */
    public function changeTemperature($device, $location, float $toTemperature, bool $temporary = true)
    {
        $deviceId = $device;
        if ($device instanceof Device) {
            $deviceId = $device->getId();
        }

        $locationId = $location;
        if ($location instanceof Location) {
            $locationId = $location->getId();
        }

        $response = $this->request('v2/devices/thermostats/'.$deviceId, 'POST', [
            "mode" => $this->determineMode($device, $toTemperature),
            "heatSetpoint" => $toTemperature,
            "coolSetpoint" => $toTemperature,
            'thermostatSetpointStatus' => $temporary ? 'TemporaryHold' : 'PermanentHold',
        ], ['locationId' => $locationId]);

        if (!$response) {
            $device->setScheduledTemperature($toTemperature);
        }

        return $device;
    }

    /**
     * @param  Device  $device
     * @param  float  $toTemperature
     *
     * @return string
     */
    private function determineMode(Device $device, float $toTemperature)
    {
        return $device->getIndoorTemperature() < $toTemperature ? 'Heat' : 'Cool';
    }

    /**
     * @param $device
     *
     * @return Device
     */
    private function responseToDevice($device) : Device
    {
        return (new Device())->setId($device->deviceID)
            ->setUnits($device->units)
            ->setOnline($device->isAlive)
            ->setName($device->userDefinedDeviceName ?? '')
            ->setIndoorTemperature($device->indoorTemperature)
            ->setOutdoorTemperature($device->outdoorTemperature)
            ->setHumidity($device->displayedOutdoorHumidity)
            ->setModel($device->deviceModel)
            ->setScheduledTemperature($device->changeableValues->heatSetpoint)
            ->setMode($device->changeableValues->mode)
            ->setModeUntil($device->changeableValues->holdUntil ?? $device->changeableValues->nextPeriodTime ?? '');
    }

}