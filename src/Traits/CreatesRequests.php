<?php


namespace Fruitcake\HoneywellClient\Traits;


trait CreatesRequests
{
    /**
     * @param  string  $endpoint
     *
     * @return mixed
     */
    private function request($endpoint, $method = 'POST', $body = null, $queryParams = null)
    {
        $queryParamsString = '';
        if ($queryParams) {
            foreach ($queryParams as $name => $value) {
                $queryParamsString .= '&'.$name.'='.$value;
            }
        }


        $response = $this->httpClient->request($method,
            $this->baseUrl.'/'.$endpoint.'?apikey='.$this->consumerKey.$queryParamsString, [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->accessCredentials->getAccessToken()),
                ],
                'body' => json_encode($body),
            ]);

        return json_decode($response->getBody()->getContents());
    }
}