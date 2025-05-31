<?php

use App\Http\Controllers\Api\CatalogueController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PusherController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('api')->group(function () {
    Route::group(['prefix' => 'product'], function () {
        Route::get('/{slug?}', [ProductController::class, 'index']);
    });

    Route::group(['prefix' => 'image'], function () {
        Route::get('{name?}', [ImageController::class, 'index']);
    });

    Route::group(['prefix' => 'catalogue'], function () {
        Route::get('{slug?}', [CatalogueController::class, 'index']);
    });

    Route::group(['prefix' => 'pusher'], function () {
        Route::post('/broadcast', [PusherController::class, 'broadcast'])->name('api.pusher.broadcast');
        Route::post('/receive', [PusherController::class, 'receive'])->name('api.pusher.receive');
    });
});
