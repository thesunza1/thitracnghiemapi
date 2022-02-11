<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamQueRel;

class ExamQueRelController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function test04()
    {
        $data = ExamQueRel::select('question_id')->where('exam_staff_id', 7)->distinct()->get();
        $n = count($data);
        echo $n;
    }

    public function apiCheck(Request $request)
    {
        $examQueRelId = $request->examQueRelId;
        $examQueRel = ExamQueRel::find($examQueRelId);
        $examQueRel->chose = 1;
        $examQueRel->save();
    }
    public function apiUnCheck(Request $request)
    {
        $examQueRelId = $request->examQueRelId;
        $examQueRel = ExamQueRel::find($examQueRelId);
        $examQueRel->chose = -1;
        $examQueRel->save();
    }
}
