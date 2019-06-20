<?php


namespace Fruitcake\Honeywell\Traits;


trait CreatesRequests
{
    /**
     * @param  string  $endpoint
     *
     * @return mixed
     */
    private function request(string $endpoint, array $body = null, array $queryParams = null)
    {
        $queryParamsString = '';
        if ($queryParams) {
            foreach ($queryParams as $name => $value) {
                $queryParamsString .= '&'.$name.'='.$value;
            }
        }

        $response = $this->httpClient->request('GET', $this->baseUrl.'/'.$endpoint.'?apikey=' .$this->consumerKey . $queryParamsString, [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->accessCredentials->getAccessToken()),
            ],
            'form_params' => $body,
        ]);

        return json_decode($response->getBody());
    }
}