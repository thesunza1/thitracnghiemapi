<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\ExamQueRel;
use App\Models\Relies;

class ReliesController extends Controller
{
    public function __construct()
    {
     $this->middleware('auth')   ;
    }
    public function add(Request $request, $id)
    {
        $answer = new Relies();
        $answer->question_id = $id;
        $answer->noidung = $request->more_answer;
        if($request->is_correct == "on")
        {
            $answer->answer = 1;
        }else
        {
            $answer->answer = 0;
        }
        // dd($request->all());
        $answer->save();
        return redirect('/question/edit/' . $id);
    }

    public function is_correct(Request $request, $id){
        $answer = Relies::find($id);
        if($request->val == "true")
            $answer->answer = 1;
        else
            $answer->answer = 0;
        $answer->save();
        echo $request->val;
    }

    public function delete($id)
    {
        $answer = Relies::find($id);
        $answer->delete();
    }

    public function choose($t_id, $q_id, $a_id){
        $que_rels = ExamQueRel::where('exam_staff_id','=',$t_id)->where('question_id','=', $q_id)->get();
        $que_rels->each(function($item, $key){
            $item->chose = -1;
            $item->save();
        });

        $que_rel = ExamQueRel::where('exam_staff_id',$t_id)->where('question_id', $q_id)->where('relies_id', $a_id)->first();
        $que_rel->chose = 1;
        $que_rel->save();
        echo "ok";
    }
}
