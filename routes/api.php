<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('vaccinations', [Controllers\VaccinationController::class,'index']);
Route::get('vaccination/{id}', [Controllers\VaccinationController::class,'findByID']);

Route::get('users', [Controllers\UserController::class,'index']);
Route::get('users/{id}', [Controllers\UserController::class,'findByID']);
Route::get('users/cecksvnr/{svnr}', [Controllers\UserController::class,'checkSVNR']);

Route::get('locations', [Controllers\LocationController::class,'index']);
Route::post('auth/login', [Controllers\AuthController::class,'login']);


Route::group(['middleware' => ['api', 'auth.jwt']], function (){
    Route::post('vaccination', [Controllers\VaccinationController::class,'save']);
    Route::put('vaccination/{id}', [Controllers\VaccinationController::class,'update']);
    Route::delete('vaccination/{id}', [Controllers\VaccinationController::class,'delete']);
    Route::post('auth/logout', [Controllers\AuthController::class,'logout']);
    Route::put('users/{id}', [Controllers\UserController::class,'updateUser']);
});
