<?php

namespace UserAccount\Service\Google\Authentication;

use Google\Service\Oauth2\Userinfo;
use Google_Client;
use Google_Service_Oauth2;
use JetBrains\PhpStorm\ArrayShape;

final class GoogleAuthentication
{
    private Google_Client $googleClient;

    public function __construct(Google_Client $googleClient)
    {
        $this->googleClient = $googleClient;
    }

    public function getUserData(string $code): Userinfo
    {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
        $this->googleClient->setAccessToken($token['access_token']);

        $googleOauth = new Google_Service_Oauth2($this->googleClient);
        return $googleOauth->userinfo->get();
    }
}
