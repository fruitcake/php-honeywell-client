<?php


namespace Fruitcake\Honeywell;

use Fruitcake\Honeywell\Models\HoneywellAccessCredentials;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;


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
     * @var callable $onCredentialsCallback
     */
    protected $onCredentialsCallback;

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
            $this->refreshAccessToken();
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
    private function refreshAccessToken()
    {
        $response = $this->httpClient->request('POST', $this->tokenUrl, [
            'form_params' => [
                'refresh_token' => $this->accessCredentials->getRefreshToken(),
                'grant_type' => 'refresh_token',
                'redirect_uri' => $this->redirectUri,
            ],
            'headers' => [
                'Authorization' => sprintf('Basic %s', $this->getBase64Key()),
            ],
        ]);

        $this->toAccessCredentials($response);
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
                'redirect_uri' => $this->redirectUri,
            ],
            'headers' => [
                'Authorization' => sprintf('Basic %s', $this->getBase64Key()),
            ],
        ]);

        $this->toAccessCredentials($response);

    }

    /**
     * @return string
     */
    private function getBase64Key()
    {
        return base64_encode(sprintf('%s:%s', $this->consumerKey, $this->consumerSecret));
    }

    /**
     * @param  callable  $onCredentialsCallback
     *
     * @return HoneywellClient
     */
    public function setOnCredentialsCallback(callable $onCredentialsCallback) : HoneywellClient
    {
        $this->onCredentialsCallback = $onCredentialsCallback;

        return $this;
    }

    /**
     * @param  ResponseInterface  $response
     */
    private function toAccessCredentials(ResponseInterface $response) : void
    {
        $body = json_decode($response->getBody());
        $this->accessCredentials->setAccessToken($body->access_token);
        $this->accessCredentials->setRefreshToken($body->refresh_token);
        $this->accessCredentials->setTokenExpireTime(time() + $body->expires_in);

        ($this->onCredentialsCallback)($this->accessCredentials);
    }


}