<?php

namespace App\Http\Controllers;

use App\Services\BlizzardService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;

class CharacterController extends Controller
{
    /**
     * @param BlizzardService $blizzard
     * @param string $realm
     * @param string $name
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function getCharacterData(BlizzardService $blizzard, string $realm, string $name): JsonResponse
    {
        $character = $blizzard->getCharacter($realm, $name);

        return response()->json($character);
    }

    /**
     * @param BlizzardService $blizzard
     * @param string $realm
     * @param string $name
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function getCharacterMedia(BlizzardService $blizzard, string $realm, string $name): JsonResponse
    {
        $media = $blizzard->getCharacterMedia($realm, $name);
        return response()->json($media);
    }
}
