<?php

namespace App\Http\Controllers;

use App\Http\Responses\CharacterMediaResponse;
use App\Services\BlizzardService;
use Exception;
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
     * @throws Exception
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
     * @return array
     * @throws Exception
     */
    public function getCharacterMedia(BlizzardService $blizzard, string $realm, string $name): array
    {
        $media = $blizzard->getCharacterMedia($realm, $name);

        return CharacterMediaResponse::one($media);
    }
}
