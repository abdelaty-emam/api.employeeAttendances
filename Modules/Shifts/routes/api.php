<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Shifts\App\Http\Controllers\ShiftsController;

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
    Route::get('shifts', fn (Request $request) => $request->user())->name('shifts');
});

/** Backend **/
Route::group(
    [
        'prefix'     => 'v1/backend'
    ],
    function () {
        Route::apiResource('shifts', ShiftsController::class);
    }
);
