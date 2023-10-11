<?php
namespace app\library;

use Google\Client;
use Google\Service\Oauth2 as ServiceOauth2;
use Google\Service\Oauth2\UserInfo;
use GuzzleHttp\Client as GuzzleClient;

class GoogleClient
{
    public readonly Client $client;
    private UserInfo $data;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function init()
    {
        $guzzleClient = new GuzzleClient(config: ['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
        $this->client->setHttpClient(http: $guzzleClient);
        $this->client->setAuthConfig(config: 'credentials.json');
        $this->client->setRedirectUri(redirectUri: 'http://localhost:8000');
        $this->client->addScope(scope_or_scopes: 'email');
        $this->client->addScope(scope_or_scopes: 'profile');
    }

    public function authorized()
    {
        if(isset($_GET['code'])){
            $token = $this->client->fetchAccessTokenWithAuthCode(code: $_GET['code']);
            $this->client->setAccessToken(token: $token['access_token']);
            $googleService = new ServiceOauth2($this->client);
            $this->data = $googleService->userinfo->get();
            
            return true;
        }

        return false;
    }

    public function getData()
    {
        return $this->data;
    }

    public function generateAuthLink()
    {
        return $this->client->createAuthUrl();
    }
}