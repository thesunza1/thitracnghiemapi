@extends('layouts.default')

@section('style')

    <style>
        .delete_answer:hover{
            cursor: pointer;
            line-height:24px;
            font-size:25px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div><h3 class="text-center">Thông tin về câu hỏi</h3></div>
        <div class="row m-0">
            <div class="col-md-12 col-md-offset-3 text-center">
                <p class="wow fadeIn" data-wow-duration="2s">Edit your question here.</p>
            </div>
        </div>
        <div class="d-flex pt-3">
            <div class="border border-grey rounded p-2 col-md-8">

                <form action="/question/update" method="post">
                    @csrf
                    <div class="form-group" hidden>
                        <input id="id" class="form-control" type="text" name="id" value="{{$question->id}}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level">Mức độ</label>
                                <select name="level" id="level" class="form-control">
                                    @foreach ($levels as $level)
                                        @if ($question->level->id == $level->id)
                                            <option value="{{ $level->id}}" selected>{{ $level->difficult }}</option>
                                        @else
                                            <option value="{{ $level->id}}">{{ $level->difficult }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="theme">Chủ đề</label>
                                <select name="theme" id="theme" class="form-control">
                                    @foreach ($themes as $theme)
                                        @if ($question->theme->id == $theme->id)
                                            <option value="{{ $theme->id}}" selected>{{ $theme->name }}</option>
                                        @else
                                            <option value="{{ $theme->id}}">{{ $theme->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <textarea name="content" id="content" class="form-control">{{$question->content}}</textarea>
                    </div>
                    <div class="row">
                        <?php
                            $i = 1;
                            $arr = ['0','A','B','C','D','E','F','G','H','I','J','K','L','M','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                         ?>
                        @foreach ($question->relies as $a)
                            <div class="col-md-6 mb-4">
                                <label for="answer{{$i}}" style="font-weight: 700;">Đáp án {{$arr[$i]}}</label>
                                <div class="form-group input-group">
                                    <input id="answer{{$i}}" {{($a->answer) ? "style=background-color:#7de07154" : ""}} class="form-control {{($a->answer) ? "border border-success" : "" }}" type="text" name="answer{{$i++}}" value="{{$a->noidung}}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text delete_answer text-danger border-danger" id="{{$a->id}}">X</span>
                                    </div>
                                </div>
                                <input type="checkbox" class="is_correct" id="{{$a->id}}" {{$a->answer ? "checked" : ""}}>
                                    <label for="is_correct">Đúng</label>
                            </div>
                        @endforeach
                    </div>
                    <button class="btn btn-warning" type="submit">Thay đổi</button>
                </form>
            </div>
            <div class="border border-grey rounded p-2 ml-1 col-md-4">
                <div><h3>Thêm câu trả lời cho câu hỏi</h3></div>
                <div id="more_answer">
                    <form action="/answer/add/{{$question->id}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="answer">Đáp án {{$arr[$i]}}</label>
                            <input id="answer" class="form-control" type="text" name="more_answer">
                            <input type="checkbox" name="is_correct" id="is_correct" class="mt-2">
                            <label for="is_correct">Đúng</label>
                        </div>
                        <div>
                            <button class="btn btn-primary">Thêm đáp án</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-content')

    <script>
        $(document).ready(function(){
            new WOW().init();
            $(".is_correct").change(function(){
                let val = $(this).is(":checked");
                let id = $(this).attr("id");
                let path = window.location.pathname;
                // console.log(val);
                $.ajax({
                    type: "POST",
                    url:"/answer/is_correct/"+id,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "val" : val
                    },
                    success: function(msg){
                        console.log(msg)
                        window.location = path;
                    }
                });
            });

            $(".delete_answer").click(function(){
                let id = $(this).attr("id");
                let path = window.location.pathname;
                $.ajax({
                    type: "POST",
                    url: "/answer/delete/"+id,
                    data:{
                        "_token": "{{csrf_token()}}"
                    },
                    success: function(){
                        window.location = path;
                    }
                });
            });
        });
    </script>
@endsection
