<?php

namespace App\Http\Controllers;

use App\Models\ExamQueRel;
use Illuminate\Http\Request;
use App\Models\Exams;

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
        $exams = Exams::where('contest_id', $contestId)->with('examstaffs', function ($q) use ($userId) {
            return $q->where('staff_id', $userId);
        })->with('staff')->orderByDesc('created_at')->get();
        return response()->json([
            'exams' => $exams,
            'statuscode' => 1,
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
        })->orderBy('order_question')->get();

        $numQues = ExamQueRel::where('exam_staff_id', $examStaffId)->select('order_question')->distinct('order_question')->count();
        return response()->json([
            'questions' => $res,
            'numQuest' => $numQues,
            'statuscode' => 1,
        ]);
    }
}
