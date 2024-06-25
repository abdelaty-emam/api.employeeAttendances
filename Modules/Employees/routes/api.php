<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Employees\App\Http\Controllers\EmployeesController;

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
    Route::get('employees', fn (Request $request) => $request->user())->name('employees');
});

/** Backend **/
Route::group(
    [
        'prefix'     => 'v1/backend'
    ],
    function () {
        Route::apiResource('employees', EmployeesController::class)->names('employees');
    }
);
