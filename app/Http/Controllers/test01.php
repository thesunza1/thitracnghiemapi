<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\ExamQueRel;
use Illuminate\Support\Facades\DB;



class test01 extends Controller

{



    public function index() {

        DB::table('users')->insert(['name'=>'helloo']);

        $users = DB::table('users')->get();

        echo "gia huy 0111";

    }
    public function testdethi() {
        $id = 5 ;
        $datas = ExamQueRel::where('exam_staff_id', $id)->orderBy('order_question')->orderBy('order_relies')->get();
        $order = 0 ;
        $question_id =0 ;
        echo '<h1>de thi cho </h1>';
        foreach($datas as $data) {
            $temp = $data->order_question;
            if($order != $temp) {
                $order = $temp;
                $question_id = $data->question_id ;
                echo "<h5>cau $order : ". $data->question->content."</h5>" ;

            }
            echo "<p style='padding-left :50px'>". $data->relies->noidung ." </p>";
        }
    }

}

