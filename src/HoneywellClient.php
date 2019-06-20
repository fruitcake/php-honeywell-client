<?php


namespace Fruitcake\Honeywell;

use Fruitcake\Honeywell\Models\HoneywellAccessCredentials;
use GuzzleHttp\Client;


class HoneywellClient
{
    /**
     * @var string $authUrl
     */
    private $authUrl = 'https://api.honeywell.com/oauth2/authorize';

    /**
     * @var string $tokenUrl
     */
    private $tokenUrl = 'https://api.honeywell.com/oauth2/token';

    /**
     * @var Client $httpClient
     */
    protected $httpClient;

    /**
     * @var HoneywellAccessCredentials $accessCredentials
     */
    protected $accessCredentials;

    /**
     * @var string $redirectUri
     */
    protected $redirectUri;

    /**
     * @var string $consumerKey
     */
    protected $consumerKey;

    /**
     * @var string $consumerSecret
     */
    protected $consumerSecret;

    /**
     * HoneywellClient constructor.
     *
     * @param Client $httpClient
     * @param string $redirectUri
     * @param string $consumerKey
     * @param string $consumerSecret
     */
    public function __construct($redirectUri, $consumerKey, $consumerSecret, Client $httpClient = null, HoneywellAccessCredentials $accessCredentials = null)
    {
        $this->redirectUri = $redirectUri;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->httpClient = $httpClient ?? new Client();
        $this->accessCredentials = $accessCredentials ?? new HoneywellAccessCredentials();
    }


    /**
     *
     * Authenticate with honeywell if nessecary.
     *
     * @return $this
     */
    public function authenticate()
    {
        if (request('code')) {
            $this->accessCredentials->setAuthorizationCode(request('code'));
        }

        if (!$this->accessCredentials->getAuthorizationCode() && !request('code')) {
            $this->redirectToAuthorizationPage();
        }
        if (!$this->accessCredentials->getRefreshToken() && !$this->accessCredentials->getAccessToken()) {
            $this->requestAccessToken();

        }

        if ($this->accessCredentials->accessTokenIsExpired() && $this->accessCredentials->getRefreshToken()) {
            $this->requestAccessToken($this->accessCredentials->getRefreshToken());
        }


        return $this;
    }

    /**
     * Redirect if not authenticated yet.
     */
    private function redirectToAuthorizationPage()
    {
        header('Location: '.$this->authUrl.'?'.http_build_query([
                'client_id' => $this->consumerKey,
                'response_type' => 'code',
                'redirect_uri' => $this->redirectUri,
            ]));

        exit;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function requestAccessToken()
    {

        $response = $this->httpClient->request('POST', $this->tokenUrl, [
            'form_params' => [
                'code' => $this->accessCredentials->getAuthorizationCode(),
                'grant_type' => 'authorization_code',
            ],
            'headers' => [
                'Authorization' => sprintf('Basic %s', $this->getBase64Key()),
            ],
        ]);
        dd($response);
    }

    /**
     * @return string
     */
    private function getBase64Key()
    {
        return base64_encode(sprintf('%s:%s', $this->consumerKey, $this->consumerSecret));
    }


}