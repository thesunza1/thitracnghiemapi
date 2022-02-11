@extends('layouts.default')

@section('style')

@endsection

@section('content')
    <?php
        $order = 0;
        $arr = ['0','A','B','C','D','E','F','G','H','I','J','K','L','M','O'];
    ?>
    <div class="container pt-3">
        <div class='text-center'>
            <h3>Bài thi của {{$exam->staff->name}}</h3>
            <h4>Kì thi : {{App\Models\Exams::find($exam->exam_id)->contest->name}}</h4>
        </div>
        <div class='d-flex'>
            <h3>Kết quả : <span class='result'></span></h3>
            <h3 class='pl-5'>Số điểm : {{$exam->point}}</h3>
        </div>
        @foreach ($tests as $data)
        <?php $temp = $data->order_question;?>
        <?php if($order != $temp):$order = $temp;$question_id = $data->question_id ;$j = 1;?>
            <h4 class='pt-3 pb-1 question'>Câu {{$order}} : {{$data->question->content}}</h4>
        <?php endif; ?>
        {{-- <p style='padding-left :50px'>{{$arr[$j++] .". ". $data->relies->noidung}}</p> --}}
        <div class="answer-field">
            <span class="answer border p-2 mb-1 {{(App\Models\Relies::find($data->relies_id)->answer == 1) ? 'border-success' : ''}}" style="display:flex;align-items: center">
                <input type="radio" name="answer[{{$temp}}]" onclick='return false;' class="mr-1 {{($data->chose == 1) ? 'checked' :''}}" id="{{$data->relies_id}}" data="{{$data->question_id}}">
                <label for="{{$data->relies_id}}" class="m-0">{{$arr[$j++] . ". " .$data->relies->noidung}}</label>
            </span>
        </div>
        @endforeach
    </div>
@endsection

@section('js-content')
<script>
    $(function(){
        $(".checked").attr("checked",true).closest('.answer').addClass('border-danger');
        $('.border-success').removeClass('border-danger');
        // $(".answer-field").click(function(){
        //     let name = $(this).find('input').attr('name');
        //     let id_answer = $(this).find('input').attr('id');
        //     let id_question = $(this).find('input').attr('data');
        //     $('input[name="'+name+'"]').attr("checked",false);
        //     $(this).find('input').attr("checked",true);
        //     console.log('id_quiz - id_answer - id_test');
        //     console.log(id_question + ' - ' + id_answer + ' - ' + id_exam);
        // });
        let correct = $('.checked').parents('.border-success').length;
        let total = $('.question').length;
        $('.result').html(correct + '/' + total);
    });
</script>
@endsection
