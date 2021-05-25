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

//CRUD Methoden Impftermin
Route::get('vaccinations', [Controllers\VaccinationController::class,'index']);
Route::get('vaccination/{id}', [Controllers\VaccinationController::class,'findByID']);

//CRUD Methoden User
Route::get('users', [Controllers\UserController::class,'index']);
Route::get('users/{id}', [Controllers\UserController::class,'findByID']);
Route::delete('user/{id}', [Controllers\UserController::class,'delete']);
Route::post('user', [Controllers\UserController::class,'save']);


//CRUD Methoden Impfort
Route::get('locations', [Controllers\LocationController::class,'index']);
Route::get('location/{id}', [Controllers\LocationController::class,'findByID']);
Route::delete('location/{id}', [Controllers\LocationController::class,'delete']);
Route::post('location', [Controllers\LocationController::class,'save']);
Route::put('location/{id}', [Controllers\LocationController::class,'update']);

//LOGIN
Route::post('auth/login', [Controllers\AuthController::class,'login']);


Route::group(['middleware' => 'api', 'auth.jwt']], function (){
    Route::post('vaccination', [Controllers\VaccinationController::class,'save']);
    Route::put('vaccination/{id}', [Controllers\VaccinationController::class,'update']);
    Route::delete('vaccination/{id}', [Controllers\VaccinationController::class,'delete']);
    Route::post('auth/logout', [Controllers\AuthController::class,'logout']);
    Route::put('users/{id}', [Controllers\UserController::class,'updateUser']);
});
