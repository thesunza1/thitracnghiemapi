<?php

use App\Http\Controllers\ContestsController;
use App\Http\Controllers\ExamQueRelController;
use App\Http\Controllers\ExamStaffsController;
use App\Http\Controllers\StaffsController;
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

// Route::get('/user/get', function (Request $request) {
//     return $request->user()->id;
// });


Route::post('login', [StaffsController::class, 'ApiLogin']);


Route::middleware(['auth:sanctum'])->group(
    function () {
        //get login user
        Route::get('staff/get', [StaffsController::class, 'ApiGetUser']);
        //contest
        Route::get('contests', [ContestsController::class,'ApiGetContests']);
        //examstaff controller
        Route::get('contest/{contestId}/exam/get', [ExamStaffsController::class,  'apiGetExams']);
        Route::get('contest/exam/toExam/{examStaffId}', [ExamStaffsController::class, 'apiGetToExams']);
        //examQueRels controller
        Route::Post('exam/check', [ExamQueRelController::class, 'apiCheck']);
        Route::Post('exam/unCheck', [ExamQueRelController::class, 'apiUnCheck']);
        Route::Post('exam/submit', [ExamStaffsController::class, 'apiSubmitExam']);
    }
);
