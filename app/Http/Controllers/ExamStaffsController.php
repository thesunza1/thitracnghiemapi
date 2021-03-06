<?php

namespace App\Http\Controllers;

use App\Models\Contests;
use App\Models\ExamQueRel;
use Illuminate\Http\Request;
use App\Models\Exams;
use App\Models\ExamStaffs;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamStaffsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    // ------------------------------
    //get exam with examStaffs
    public function apiGetExams(Request $request)
    {
        $userId = $request->user()->id;
        $contestId = $request->contestId;
        $contest = Contests::where('id',$contestId)->pluck('content')->first();
        $exams = Exams::where('contest_id', $contestId)->with('examstaffs', function ($q) use ($userId) {
            return $q->where('staff_id', $userId);
        })->with('staff')->orderByDesc('created_at')->get();
        return response()->json([
            'exams' => $exams,
            'statuscode' => 1,
            'contest' => $contest,
        ]);
    }
    //get exam when to exam
    public function apiGetToExams(Request $request)
    {
        $examStaffId = $request->examStaffId;
        $examQueRels = ExamQueRel::where('exam_staff_id', $examStaffId);
        $res = $examQueRels->with('relies', function ($q) {
            return $q->select('id', 'noidung');
        })->with('question', function ($q) {
            return $q->select('id', 'content');
        })->orderBy('order_question')->orderBy('order_relies')->get();

        $numQues = ExamQueRel::where('exam_staff_id', $examStaffId)->select('order_question')->distinct('order_question')->count();
        $examStaff = ExamStaffs::find($examStaffId);
        if ($examStaff->time_limit == null) {
            $timeLimit = date('Y-m-d H:i:s', time() + ($examStaff->exam->examtime_at * 60));
            $examStaff->time_limit = $timeLimit;
            $examStaff->save();
            //
        }
        $hour = ((int)date('H',($examStaff->time_limit )) - (int)date('H')) * 60 +
            ((int)date('i', ($examStaff->time_limit )) - (int)date('i'));


        return response()->json([
            'questions' => $res,
            'numQuest' => $numQues,
            'statuscode' => 1,
            'minutes' => $hour,
        ]);
    }
    function apiSubmitExam(Request $request)
    {
        $userId = $request->user()->id;

        $examStaffId = $request->examStaffId;

        $bindings = [
            'v_exam_id' => $userId,
            'v_estaff_id' => $examStaffId
        ];
        $procedure_name = 'THUCTAP.P_CACL_POINT';
        $init = DB::executeProcedure($procedure_name, $bindings);

        return response()->json([
            'statuscode' => 1,
        ]);
    }
}
