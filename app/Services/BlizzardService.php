<?php

namespace App\Services;

use Exception;

class BlizzardService
{
    protected BlizzardClient $client;

    public function __construct()
    {
        $this->client = new BlizzardClient('eu');
    }

    /**
     * @param string $realm
     * @param string $name
     * @return array
     * @throws Exception
     */
    public function getCharacter(string $realm, string $name): array
    {
        return $this->client->get("/profile/wow/character/{$realm}/{$name}");
    }

    /**
     * @param string $realm
     * @param string $name
     * @return array
     * @throws Exception
     */
    public function getCharacterMedia(string $realm, string $name): array
    {
        $character = $this->getCharacter($realm, $name);

        if (!isset($character['media']['href'])) {
            throw new Exception("Character media not found");
        }

        $url = $character['media']['href'];

        return $this->client->get($url, ['namespace' => "profile-{$this->client->getRegion()}"]);
    }
}
