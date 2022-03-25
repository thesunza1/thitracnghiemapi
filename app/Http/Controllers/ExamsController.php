<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exams;
use App\Models\ExamThemes;
use App\Models\Contests;
use App\Models\ExamDetails;
use App\Models\ExamQueRel;
use App\Models\ExamStaffs;
use Illuminate\Support\Facades\Auth;

class ExamsController extends Controller
{
    public function __construct()
    {
     $this->middleware('auth')   ;
    }


    public function index($id) {
        $exams = Exams::where('contest_id',$id)->get();
        $contest = Contests::find($id)->first();

        return view('exams.index')->with('exams', $exams)
        ->with('contest', $contest);
    }
    public function detail($id){
        $exam = Exams::find($id);
        $questions = ExamDetails::where('exam_id', $id)->get();
        return view('exams/detail')->with('questions', $questions)->with('exam', $exam);
    }

    public function add(Request $request, $id)
    {
        $exam = new Exams();
        $exam->contest_id = $id;
        $exam->issuer_id = Auth::user()->id;
        $exam->questionnum = $request->q_num;
        if(isset($request->q_mix))
            $exam->questionmix = 1;
        else
            $exam->questionmix = 0;

        if(isset($request->a_mix))
            $exam->relymix = 1;
        else
            $exam->relymix = 0;
        $exam->examtime_at = $request->examtime_at;
        $exam->save();

        for($i = 0; $i < count($request->theme); $i++)
        {
            $exam_theme = new ExamThemes();
            $exam_theme->theme_id = $request->theme[$i];
            $exam_theme->level_id = $request->level[$i];
            $exam_theme->question = $request->q_num_per_theme_level[$i];
            $exam->exam_themes()->save($exam_theme);
        }
        return redirect('/contest/detail/' . $id . "#exam");
        dd($exam_theme);
    }


    public function test03($id) {
        // echo $id ;

        $exams = Exams::where('contest_id', '=', $id)->get() ;
        // select * from exams where contest_id = 2 ;
        // dd($exams);
        // foreach($exams as $a) {
        //     echo $a->questionmix.' ';
        // }

        return view('exams.test03')->with('exams',$exams);
    }

    public function delete($id){
        $exam = Exams::find($id);
        $exam->delete();
        return redirect()->back();
    }

    public function alltest($id) {
        $exams = ExamStaffs::where('exam_id', $id)->get();
        return view('exams/alltest')->with('exams', $exams);
    }

    public function taking($id)
    {
        $exam_staff = ExamStaffs::where('exam_id', $id)->where('staff_id', Auth::user()->id)->first();
        if($exam_staff->point == '-1'){
            $exam = Exams::find($id);
            if($exam_staff->time_limit == NULL){
                $time = $exam->examtime_at;
                $exam_staff->time_limit = date('Y-m-d H:i:s', time() + ($time*60));
                // dd($exam_staff);
                $exam_staff->save();
            }
            $exam_staff = ExamStaffs::where('exam_id', $id)->where('staff_id', Auth::user()->id)->get();
            return view('exams/taking')->with('exam', $exam)->with('exam_staff', $exam_staff);
        }
        else{
            return redirect()->route('exam.result', ['id' => $id]);
        }
    }

    public function execute(Request $request) {
        $exam_staff = ExamStaffs::where('exam_id', $request->id)->where('staff_id', $request->user()->id)->first() ;
        $data = $exam_staff->examQueRels()->with('question.relies')->paginate(5);
        $data->appends(['oke' => 'okesmen'])->links() ;
        dd($data->oke);
    }

    public function result($id){
        $exam = ExamStaffs::where('exam_id', $id)->where('staff_id', Auth::user()->id)->get()->first();
        $id = $exam->id;
        $tests = ExamQueRel::where('exam_staff_id', $id)->orderBy('order_question')->orderBy('order_relies')->get();
        $exam = ExamStaffs::find($id);
        return view('exams/test_detail')->with('tests', $tests)->with('exam', $exam);
    }

    public function test_detail($id){
        $tests = ExamQueRel::where('exam_staff_id', $id)->orderBy('order_question')->orderBy('order_relies')->get();
        $exam = ExamStaffs::find($id);
        return view('exams/test_detail')->with('tests', $tests)->with('exam', $exam);
    }
}
