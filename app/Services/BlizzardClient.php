<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BlizzardClient
{
    protected Client $client;
    protected string $region;
    protected string $baseUrl;

    /**
     * @param string $region
     * @param string $baseUrl
     */
    public function __construct(string $region = 'eu', string $baseUrl = 'https://eu.api.blizzard.com')
    {
        $this->region = $region;
        $this->baseUrl = $baseUrl;
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * @return string
     */
    protected function getAccessToken(): string
    {
        return Cache::remember('blizzard_access_token', 3600, function () {
            $clientId = config('services.blizzard.client_id');
            $clientSecret = config('services.blizzard.client_secret');

            $response = Http::withBasicAuth($clientId, $clientSecret)
                ->asForm()
                ->post("https://{$this->region}.battle.net/oauth/token", [
                    'grant_type' => 'client_credentials',
                ]);

            if (!isset($response['access_token'])) {
                throw new Exception('Failed to fetch Blizzard access token.');
            }

            return $response['access_token'];
        });
    }

    /**
     * @param string $endpoint
     * @param array $query
     * @return array
     * @throws Exception
     */
    public function get(string $endpoint, array $query = []): array
    {
        $token = $this->getAccessToken();

        $query = array_merge([
            'namespace' => "profile-{$this->region}",
            'locale' => 'en_GB',
        ], $query);

        try {
            $response = $this->client->get($endpoint, [
                'query' => $query,
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new Exception("Blizzard API request failed: " . $e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }
}
