<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Attendance\App\Http\Controllers\AttendanceController;

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
    Route::get('attendance', fn (Request $request) => $request->user())->name('attendance');
});


/*mobile*/
Route::group(
    [
        'middleware' => 'api',
        'prefix'     => 'v1'
    ],
    function () {
        Route::post('/checkin', [AttendanceController::class, 'checkin']);
        Route::post('/checkout', [AttendanceController::class, 'checkout']);
        Route::get('/attendance-history', [AttendanceController::class, 'attendanceHistory']);
    }
);
