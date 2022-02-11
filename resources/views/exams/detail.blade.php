@extends('layouts.default')

@section('style')
 <style>
    .bg-question{
    padding : 10px;
    background-color : whitesmoke;
    }
    .question{
    border : 1px solid black;
    width : 100%;
    padding : 10px;
    }
    .answer:hover{
    cursor: pointer;
    }
    .answer-field{
    padding-top : 10px;
    }
    .answer{
    border : 1px solid black;
    width : 600px;
    padding : 5px;
    margin-top : 5px;
    }
    .answer:hover{
    background-color : rgba(187, 241, 243, 0.884) !important;
    }
    .question:hover{
        cursor: pointer;
    }
 </style>
@endsection
@section('content')
    <?php $i = 1; ?>
    <div class="container">
        <div>
            <h3 class="text-center">Danh sách câu hỏi của đề thi</h3>
        </div>
        <div class="py-2">
            @if(App\Models\ExamStaffs::where('exam_id', $exam->id)->count() == 0)
                <form action="{{route('exam.duplicate', ['id' => $exam->id])}}" method="post">
                    @csrf
                    <button class="btn btn-danger duplicate" onclick="function(){$(this).find('form').submit();}">Chia đề</button>
                </form>
            @else
                <a href="{{route('exam.alltest', ['id' =>$exam->id])}}" class="btn btn-success">Xem danh sách đã chia</a>
            @endif
        </div>
        @foreach ($questions as $question)
        <?php
            $q = App\Models\Questions::find($question->question_id);
            $j = 1;
            $arr= ['0','A',  'B', 'C', 'D', 'E', 'F'];
        ?>
            <div class="bg-question bd">
                <h3 class="text-black">
                  Câu {{$i++}}
                </h3>
                <div class="question bg-white" id="question-{{$q->id}}" data="{{$q->id}}">
                    {{$q->content}}
                </div>
                <div id="answer-{{$q->id}}" class="d-none">
                    <div class="answer-field" >
                        <div>
                            @foreach ($q->relies as $answer)
                                <span class="answer {{($answer->answer) ? "bg-success" : "bg-white"}}" style="display:flex;">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="answer[][]" class="" id="answer{{$answer->id}}">
                                        <label for="answer{{$answer->id}}" class="m-0 pl-1">{{$arr[$j++] . ". " . $answer->noidung}}</label>
                                    </div>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('js-content')
<script>
    $(function(){
        $(".answer").click(function(){
            $(this).siblings().css("background-color", "white").find("input").attr("checked",false);
            $(this).css("background-color", "green").find("input").attr("checked",true);
        });

        $(".question").click(function(){
            $("#answer-"+ $(this).attr("data")).toggleClass('d-none');
            // console.log($("#answer-"+ $(this).attr("data")))
        });
    });
</script>
@endsection
