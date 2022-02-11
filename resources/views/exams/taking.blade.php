@extends('layouts.default')

@section('style')
<style>
    body {
        background-color: whitesmoke;
    }

    .answer-field {
        background-color: white;
    }

    .num-box {
        background-color: white;
        box-shadow: 0px 0px 10px gray !important;
        border: none !important;
        border-radius: 20px;
    }

    .num-box span {
        border-radius: 15%;
        height: 40px;
        line-height: 30px;
        width: 40px;
        align-items: center;
        box-shadow: 0px 0px 1px gray !important;
    }

    div.question {
        border-color: rgb(10, 66, 197) !important;
        border-radius: 5px;
        box-shadow: 0px 0px 2px rgb(10, 144, 197);
    }

    .answer-field .answer {
        border-radius: 8px;
    }

    .answer-field:hover {
        background-color: rgb(119, 187, 137);
    }

    .handin:hover {
        border-color: rgba(0, 136, 248, 0.753) !important;
    }
    .bg-grey{
        background-color: rgb(253, 213, 213);
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- questions -->
    <div class="offset-md-4 col-md-8">
        <div class="bg-question bd p-2">
            <?php
                $end_time = $exam_staff[0]->time_limit;
                $order = 0;
                $number_of_questions_per_page = 10;
                $arr = ['0','A','B','C','D','E','F','G','H','I','J','K','L','M','O'];
                $num = App\Models\ExamQueRel::where('order_question','<=', $number_of_questions_per_page)->where('exam_staff_id', $exam_staff[0]->id)->orderBy('order_question')->orderBy('order_relies')->count();
                // $questions = App\Models\ExamQueRel::where('exam_staff_id', $exam_staff[0]->id)->get();
                $questions = App\Models\ExamQueRel::where('exam_staff_id', $exam_staff[0]->id)->orderBy('order_question')->orderBy('order_relies')->paginate($num);
            ?>
            @foreach ($questions as $question)
            <?php $temp = $question->order_question;?>
            <br>
            <div class="question_{{$question->order_question}}">
                <?php if($order != $temp):$order = $temp;$question_id = $question->question_id ;$j = 1;?>
                <h3 id="question_{{$question->order_question}}" class='question'>Câu {{$question->order_question}}:</h3>
                <br>
                <div class="question border p-2 bg-white mb-3" id="{{$question->question_id}}">
                    {{$question->question->content}}</div>
                <?php endif; ?>
                <div class="answer-field">
                    <span class="answer border p-2 mb-1" style="display:flex;align-items: center" data='{{$question->order_question}}'>
                        <input type="radio" name="answer[{{$temp}}]"
                            class="mr-1 {{($question->chose == 1) ? 'checked' :''}}" id="{{$question->relies_id}}"
                            data="{{$question->question_id}}">
                        <label for="{{$question->relies_id}}"
                            class="m-0">{{$arr[$j++] . ". " .$question->relies->noidung}}</label>
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        {{-- <div>
            {{ $questions->links() }}
    </div> --}}
</div>
<!-- question tracker and timer -->
<div class="col-md-3 border border-dark fixed-top ml-5 pb-1 num-box" style="margin-top:85px;">
    <h4 class="py-2">Thời gian : <span id="timer"></span></h4>
    <div class="row p-1">
        <?php for($i = 1; $i <= $exam->questionnum; $i++): ?>
        <?php
            $j = ceil($i/$number_of_questions_per_page);
        ?>
            <span class="col-md-1 p-1 m-1 border border-dark text-center
                @foreach(App\Models\ExamQueRel::where('exam_staff_id', $exam_staff[0]->id)->where('order_question', $i)->get() as $question)
                    @if($question->chose == 1)
                        <?php echo 'bg-grey' ?>
                    @endif
                @endforeach
            " id='bg-question-{{$i}}'>
                <a href="<?php echo '?page='.$j.'#question_'.$i ?>"><?php echo $i ?></a></span>
        <?php endfor;?>
    </div>
    <form action="/exam/handin/{{$exam->id}}" method="post" id="handinform">
        @csrf
        <button class="btn border handin" onclick="function(){$(this).find('form').submit()}"><i class="fas fa-file-import"></i> Nộp bài</button>
    </form>
</div>
</div>
</div>
@endsection

@section('js-content')
<script>
    $(document).ready(function(){
        $(".checked").attr("checked",true);

        $(".answer-field").click(function(){
            let name = $(this).find('input').attr('name');
            let id_answer = $(this).find('input').attr('id');
            let id_question = $(this).find('input').attr('data');
            let question_number = $(this).find('.answer').attr('data');
            let id_exam = <?php echo $exam_staff[0]->id ?>;

            console.log(question_number);
            if(!$('#bg-question-'+question_number).hasClass('bg-grey')){
                $('#bg-question-'+question_number).addClass('bg-grey');
            }
            $('input[name="'+name+'"]').attr("checked",false);
            $(this).find('input').attr("checked",true);
            console.log('id_quiz - id_answer - id_test');
            console.log(id_question + ' - ' + id_answer + ' - ' + id_exam);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '/test/'+id_exam+'/q/'+id_question+'/a/'+id_answer,
                data:{
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(msg){
                    console.log(msg)
                },error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        // timer
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    // timer = duration;
                    $('#handinform').submit();
                }
            }, 1000);
        }
        let end_time = <?php echo $end_time; ?>;
        console.log('end_time', end_time);
        console.log('end_time', Math.floor(Date.now() / 1000));
        let time_left = end_time - Math.floor(Date.now() / 1000);
        //time
        var time = 60*10;
        // $("#timer").html("10:00");
        display = document.querySelector('#timer');
        startTimer(time_left, display);

    });
</script>
@endsection
