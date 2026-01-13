<?php

use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});


Route::get('/character/{realm}/{name}', [CharacterController::class, 'getCharacter']);
