<?php


namespace Fruitcake\Honeywell\Models;


class HoneywellAccessCredentials
{
    /**
     * @var string $accessToken
     */
    private $accessToken;

    /**
     * @var int $tokenExpireTime
     */
    private $tokenExpireTime;

    /**
     * @var string $refreshToken
     */
    private $refreshToken;

    /**
     * @var string $authorizationCode
     */
    private $authorizationCode;


    public function accessTokenIsExpired()
    {
        return time() > $this->getTokenExpireTime();
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     *
     * @return HoneywellAccessCredentials
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return HoneywellAccessCredentials
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return int
     */
    public function getTokenExpireTime()
    {
        return $this->tokenExpireTime;
    }

    /**
     * @param int $tokenExpireTime
     *
     * @return HoneywellAccessCredentials
     */
    public function setTokenExpireTime($tokenExpireTime)
    {
        $this->tokenExpireTime = $tokenExpireTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param string $authorizationCode
     *
     * @return HoneywellAccessCredentials
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;

        return $this;
    }


}