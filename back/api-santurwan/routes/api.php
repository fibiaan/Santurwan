<?php

/**
 * @autor Cesar Peña Hernandez
 * @email cesarphernandez09@gmail.com
 * @user cesarphernandez09@gmail.com
 * 
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User Controller 

Route::post('/editarUser', 'Api\UserController@editarUser');
Route::post('/createUser', 'Api\UserController@createUser');
Route::post('/inactiveUser', 'Api\UserController@inactiveUser');
Route::post('/loginUser', 'Api\UserController@loginUser');

//Sensores Controller 
Route::post('/crearLectura', 'Api\SensoresController@crearLectura');
Route::post('/editarLectura', 'Api\SensoresController@editarLectura');
Route::post('/traerUltimaLectura', 'Api\SensoresController@traerUltimaLectura');
Route::post('/traerLecturas', 'Api\SensoresController@traerLecturas');
