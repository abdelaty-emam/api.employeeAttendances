<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Leaves\App\Http\Controllers\LeaveRequestsController;
use Modules\Leaves\App\Http\Controllers\EmployeeLeaveRequestsController;
use Modules\Leaves\App\Http\Controllers\LeavesTypesController;

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
    Route::get('leaves', fn (Request $request) => $request->user())->name('leaves');
});

/** Backend **/
Route::group(
    [
        'prefix'     => 'v1/backend'
    ],
    function () {
        Route::apiResource('leave-types',LeavesTypesController::class);
        Route::get('leave-requests', [LeaveRequestsController::class, 'index']);
        Route::get('leave-requests/{id}', [LeaveRequestsController::class, 'show']);
        Route::put('leave-requests/{id}', [LeaveRequestsController::class, 'updateStatus']);
        Route::delete('leave-requests/{id}', [LeaveRequestsController::class, 'destroy']);
    }
);

/** mobile **/
Route::group(
    [
        'middleware' => 'api',
        'prefix'     => 'v1'
    ],
    function () {
        Route::post('leave-requests', [EmployeeLeaveRequestsController::class, 'store']);

        Route::get('my-leave-requests', [EmployeeLeaveRequestsController::class, 'myLeaves']);
    }
);
