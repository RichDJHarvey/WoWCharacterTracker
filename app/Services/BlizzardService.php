<?php

namespace App\Services;


use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BlizzardService
{
    protected string $region = 'eu';
    protected string $baseUrl;

    public function __construct()
    {
        $this->region = config('services.blizzard.region', 'eu');
        $this->baseUrl = "https://{$this->region}.api.blizzard.com";
    }

    public function getAccessToken(): string
    {
        return Cache::remember('blizzard_access_token', 3500, function () {
            $response = Http::asForm()->withBasicAuth(
                config('services.blizzard.client_id'),
                config('services.blizzard.client_secret'),
            )->post("https://{$this->region}.battle.net/oauth/token", [
                "grant_type" => "client_credentials",
            ]);

            if ($response->failed()) {
                throw new Exception('Failed to get Blizzard Access Token');
            }

            return $response->json('access_token');
        });
    }

    /**
     * @param string $realm
     * @param string $name
     * @return array|mixed
     * @throws ConnectionException
     */
    public function getCharacter(string $realm, string $name): mixed
    {
        $token = $this->getAccessToken();

        return Http::withToken($token)->get(
            "{$this->baseUrl}/profile/wow/character/{$realm}/{$name}",
            [
                'namespace' => "profile-{$this->region}",
                'locale' => 'en_GB',
            ]
        )->json();
    }

    /**
     * @param string $realm
     * @param string $name
     * @return mixed
     * @throws ConnectionException
     */
    public function getCharacterMedia(string $realm, string $name): mixed
    {
        $token = $this->getAccessToken();

        $character = $this->getCharacter($realm, $name);

        if(!isset($character['media']['href'])) {
            throw new Exception('Media link for character not found');
        }

        return Http::withToken($token)->get($character['media']['href'])->json();
    }
}
