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

Route::apiResource('candidates', 'CandidateController');
Route::apiResource('maps', 'MapController');
Route::apiResource('members', 'MembersController');
Route::apiResource('profiles', 'ProfileController');
Route::apiResource('regions', 'RegionController');
Route::apiResource('roles', 'RoleController');
Route::apiResource('teams', 'TeamController');
Route::apiResource('teams/{teamId}/vacancies', 'VacancyController');
Route::apiResource('teams/{teamId}/members', 'MembersController');
Route::apiResource('tiers', 'TierController');
Route::apiResource('users', 'UserController');
Route::apiResource('vacancies', 'VacancyController');
Route::apiResource('vacancies/{vacancyId}/candidates', 'CandidateController');
