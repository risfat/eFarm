<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplyDemandController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function () {

    /* -------------------------------------------------------------------------- */
    /*                                Auth Modules                                */
    /* -------------------------------------------------------------------------- */

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);


    /* -------------------------------------------------------------------------- */
    /*                         Authenticated User Modules                         */
    /* -------------------------------------------------------------------------- */


    Route::group(['middleware' => ['auth:sanctum']], function () {

        /* ---------------------------------- Users --------------------------------- */

        Route::get('/user', [UserController::class, 'getUserDetails']);
        Route::get('/users', [UserController::class, 'getusers']);


        /* ---------------------------------- Supply/Demand --------------------------------- */

        Route::post('/supply_demand/update', [SupplyDemandController::class, 'store']);


    });

});
