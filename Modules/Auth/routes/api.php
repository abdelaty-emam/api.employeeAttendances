<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\EmployeeAuthController;

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
    Route::get('auth', fn (Request $request) => $request->user())->name('auth');
});



/*mobile*/
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'v1/auth',
    ],
    function () {
        Route::post('login', [EmployeeAuthController::class, 'login']);
        Route::post('logout', [EmployeeAuthController::class, 'logout']);

    }
);
