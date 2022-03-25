<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContestsController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\StaffsController;
use App\Http\Controllers\BranchsController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\ExamQueRelController;
use App\Http\Controllers\ExamDetailsController;
use App\Http\Controllers\ReliesController;
use App\Http\Controllers\test01;

use App\Http\Middleware\checkAdmin;
use App\Http\Middleware\checkIssuerMaker;
use Doctrine\DBAL\Schema\Index;

Auth::routes([
    'reset' => false,
    'register' => false,

]);


//home
Route::get('/home',[ContestsController::class,'home'])->name('home');
Route::redirect('/', '/home' ); //redirect from / to /home when login in web


// //test
// Route::get('test03/{id}', [Examscontroller::class, 'test03'])->name('exam.test03');
// //exam_que_rels
// Route::get('test04', [ExamQueRelController::class, 'test04']);
// //test
// Route::get('testdethi',[test01::class,'testdethi']);

//check admin
Route::middleware(checkAdmin::class)->group(
    function () {
        //staff
        Route::get('/staffs', [StaffsController::class, 'index'])->name('staff.index');
        Route::get('/staffs/show/{id}', [StaffsController::class, 'show'])->name('staff.show');
        Route::post('/staffs/update', [StaffsController::class, 'update'])->name('staff.update');
        Route::post('/staffs/delete', [StaffsController::class, 'drop'])->name('staff.drop');
        Route::post('/staffs/create', [StaffsController::class, 'storge'])->name('staff.create');

        //branch
        Route::get('/branchs', [BranchsController::class, 'index'])->name('branch.index');
        Route::get('/branchs/show/{id}', [BranchsController::class, 'show'])->name('branch.show');
        Route::post('/branchs/update', [BranchsController::class, 'update'])->name('branch.update');
        Route::post('/branchs/delete', [BranchsController::class, 'drop'])->name('branch.drop');
        Route::post('/branchs/create', [BranchsController::class, 'storge'])->name('branch.create');
    }
);


//check issuer make
Route::middleware(checkIssuerMaker::class)->group(
    function () {

        Route::post('/question/update', [QuestionsController::class, 'update'])->name('question.update');
        Route::post('/question/create', [QuestionsController::class, 'create'])->name('question.create');
        Route::post('/question/delete/{id}', [QuestionsController::class, 'delete'])->name('question.delete');
        Route::get('/questions', [QuestionsController::class, 'index'])->name('questions');
        Route::get('/question/detail/{id}', [QuestionsController::class, 'detail'])->name('question.detail');
        Route::get('/question/edit/{id}', [QuestionsController::class, 'edit'])->name('question.edit');
        Route::get('/question/add', [QuestionsController::class, 'add'])->name('question.add');
        Route::post('/answer/add/{id}', [ReliesController::class, 'add']);
        Route::post('/answer/is_correct/{id}', [ReliesController::class, 'is_correct']);
        Route::post('/answer/delete/{id}', [ReliesController::class, 'delete']);

        //Contest
        Route::get('/contests', [ContestsController::class, 'index'])->name('contests');
        Route::get('/contest/add', [ContestsController::class, 'add'])->name('contest.add');
        Route::post('/contest/create', [ContestsController::class, 'create'])->name('contest.create');
        Route::get('/contest/edit/{id}', [ContestsController::class, 'edit'])->name('contest.edit');
        Route::post('/contest/update/{id}', [ContestsController::class, 'update'])->name('contest.update');
        // Route::post('/contest/delete/{id}', [ContestsController::class, 'delete'])->name('contest.delete');
        Route::get('/contest/delete/{id}', [ContestsController::class, 'delete'])->name('contest.delete');
        Route::get('/contest/detail/{id}', [ContestsController::class, 'detail'])->name('contest.detail');

        // Exam
        Route::post('/contest/detail/{id}/exam/add', [ExamsController::class, 'add'])->name('exam.add');
        Route::post('/exam/init/{id}', function($id){
            $procedure_name = 'THUCTAP.P_EXAMDETAIL';
            $bindings = [
                'v_exam_id' => $id,
            ];
            $init = DB::executeProcedure($procedure_name, $bindings);
            return redirect()->back();
            // dd($init);
        })->name('exam.init');
        Route::get('/exam/detail/{id}', [Examscontroller::class, 'detail'])->name('exam.detail');
        Route::post('/exam/delete/{id}', [Examscontroller::class, 'delete'])->name('exam.delete');
        Route::post('/exam/duplicate/{id}', function($id){
            $bindings = [
                'v_exam_id' => $id,
            ];
            $procedure_name = 'THUCTAP.P_I_EXAMSTAFFS';
            $init = DB::executeProcedure($procedure_name, $bindings);

            $procedure_name = 'THUCTAP.P_I_EXAMQUE_REL';
            $init = DB::executeProcedure($procedure_name, $bindings);
            // dd($init);
            return redirect()->back();
        })->name('exam.duplicate');
        Route::get('/exam/alltest/{id}',[ExamsController::class,'alltest'])->name('exam.alltest');
        Route::get('/test/{id}',[ExamsController::class,'test_detail'])->name('exam.test_detail');
    }
);

//show exam for contest
Route::get('/exam/index/{id}', [ExamsController::class, 'index'])->name('exam.index');
Route::get('/exam/taking/{id}', [ExamsController::class, 'taking'])->name('exam.taking');
Route::get('/exam/execute/{id}', [ExamsController::class, 'execute'])->name('exam.execute');
Route::post('/test/{t_id}/q/{q_id}/a/{a_id}', [ReliesController::class, 'choose'])->name('exam.choose');
Route::post('/exam/handin/{id}', function($id){
    $exam_staff = App\Models\ExamStaffs::where('exam_id', $id)->where('staff_id', Auth::user()->id)->first();
    $estaff_id = $exam_staff->id;
    $bindings = [
        'v_exam_id' => $id,
        'v_estaff_id' => $estaff_id
    ];
    $procedure_name = 'THUCTAP.P_CACL_POINT';
    $init = DB::executeProcedure($procedure_name, $bindings);

    $exam = App\Models\Exams::find($id);
    return redirect()->route('exam.index', ['id' => $exam->contest_id]);
    // dd($bindings);
})->name('exam.handin');
Route::get('/exam/result/{id}', [ExamsController::class, 'result'])->name('exam.result');


///////////////////////


