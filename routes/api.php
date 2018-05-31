<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::apiResource('profiles', 'ProfileController');
Route::apiResource('maps', 'MapController');
Route::apiResource('regions', 'RegionController');
Route::apiResource('teams', 'TeamController');
Route::apiResource('tiers', 'TierController');
Route::apiResource('users', 'UserController');
