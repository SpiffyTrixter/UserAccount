<?php

namespace UserAccount\Service\Google;

use Google_Client;
use JetBrains\PhpStorm\Pure;
use UserAccount\Service\Google\Authentication\GoogleAuthentication;

final class GoogleService
{
    private string $clientId = '1021266302512-tn0uk6dkl2ca4anmbrketeakt6a7spdf.apps.googleusercontent.com';
    private string $clientSecret = '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';
    private string $redirectUri = 'http://localhost/login/redirect';
    private Google_Client $googleClient;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        $client->setRedirectUri($this->redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        $this->googleClient = $client;
    }

    #[Pure] public function getGoogleAuthentication(): GoogleAuthentication
    {
        return new GoogleAuthentication($this->googleClient);
    }

    #[Pure] public function getGoogleClient(): Google_Client
    {
        return $this->googleClient;
    }
}
