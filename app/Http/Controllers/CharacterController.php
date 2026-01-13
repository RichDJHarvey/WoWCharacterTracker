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
    public function getCharacter(BlizzardService $blizzard, string $realm, string $name): JsonResponse
    {
        $character = $blizzard->getCharacter($realm, $name);

        return response()->json($character);
    }
}
