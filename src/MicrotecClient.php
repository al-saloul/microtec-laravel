<?php

namespace Alsaloul\Microtec;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class MicrotecClient
{
    protected $client;
    protected $baseUrl;
    protected $clientId;
    protected $securityKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = Config::get('microtec.baseURL');
        $this->clientId = Config::get('microtec.clientId');
        $this->securityKey = Config::get('microtec.securityKey');
    }

    public function authenticate()
    {
        $response = $this->client->post("{$this->baseUrl}/api/Auth/IntegrationLogin", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'clientId' => $this->clientId,
                'securityKey' => $this->securityKey,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function syncOrder($orderData, $authToken)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $authToken",
        ])->post("{$this->baseUrl}/api/order/SyncOrder", $orderData);

        return json_decode($response->getBody()->getContents(), true);
    }
}
