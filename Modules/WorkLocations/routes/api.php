<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\WorkLocations\App\Http\Controllers\WorkLocationsController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('worklocations', fn (Request $request) => $request->user())->name('worklocations');
});

/** Backend **/
Route::group(
    [
        'prefix'     => 'v1/backend'
    ],
    function () {
        Route::apiResource('worklocations', WorkLocationsController::class)->names('worklocations');
    }
);
