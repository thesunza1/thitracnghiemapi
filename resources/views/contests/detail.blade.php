@extends('layouts.default')
@section('style')
@endsection

@section('content')
<div class="container pt-3">
    <div class="col-md-12">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="contest">Tên Kì Thi</label>
                    <input id="contest" class="form-control border" readonly type="text" name="contest"
                        value="{{$contest->name}}">
                </div>
                <div class="col-md-6">
                    <label for="begintime_at">Thời gian bắt đầu</label>
                    <input id="begintime_at" class="form-control border" readonly type="datetime-local"
                        name="begintime_at" value="{{date("Y-m-d\TH:i", $contest->begintime_at)}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="test_maker_id">Người ra đề</label>
                    <select name="test_maker_id" id="test_maker_id" class="form-control" readonly>
                        @foreach ($staffs as $staff)
                        @if ($contest->testmaker_id == $staff->id)
                        <option value="{{ $staff->id}}" selected>{{$staff->name }}</option>
                        @else
                        <option value="{{ $staff->id}}">{{$staff->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-md-6">
                    <label for="branch">Chi nhánh</label>
                    <select name="branch" id="branch" class="form-control" readonly>
                        @foreach ($branchs as $branch)
                        @if ($contest->branchcontest_id == $branch->id)
                        <option value="{{$branch->id}}" selected>{{$branch->name }}</option>
                        @else
                        <option value="{{$branch->id}}">{{$branch->name }}</option>
                        @endif

                        @endforeach
                    </select>
                </div> --}}
            </div>

        </div>
        <div class="form-group">
            <label for="content">Text</label>
            <textarea name="content" id="content" cols="10" rows="10" readonly>{{$contest->content}}</textarea>
        </div>
    </div>
    {{-- Exam belongs to this Contest --}}
    <div class="row" style="box-shadow: 0 0 3px darkgrey;">
        <div class="col-md-6 p-3 rounded" id="exam">
            <div>
                <h3>Số lượng đề thi : <span>{{$exams->count()}}</span></h3>
            </div>
            <div class="row">
                @foreach ($exams as $exam)
                <div class="col-md-6 mb-5">
                    <div class="form-group">
                        <label for="exam_name">Đề thi {{$exam->id}}</label>
                        <p>Người phụ trách : {{$exam->staff->name}}</p>
                        <div>Số câu hỏi : {{$exam->questionnum}}</div>
                        <div>Thời gian làm bài : {{$exam->examtime_at}}</div>
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" onclick="return false;"
                                    {{($exam->questionmix) ? "checked" : ""}}>
                                <label for="" class="m-0">Trộn câu hỏi</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" onclick="return false;" {{($exam->relymix) ? "checked" : ""}}>
                                <label for="" class="m-0">Trộn đáp án</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        @if (Auth::user()->role->name == 'admin' || $exam->issuer_id == Auth::user()->id)
                            @if (App\Models\ExamDetails::where('exam_id', $exam->id)->count() == 0)
                                <form action="{{route('exam.init', ['id' => $exam->id])}}" method="post">
                                    @csrf
                                    <a href="#" class="btn btn-success init mr-1"><i class="fas fa-cogs"></i> Khởi tạo</a>
                                </form>
                            @else
                                <a href="{{route('exam.detail', ['id'=>$exam->id])}}" class="btn btn-info mr-1"><i
                                    class="fas fa-sign-out-alt"></i> Đề thi</a>
                                @if (App\Models\ExamStaffs::where('exam_id', $exam->id)->count() !== 0)
                                    <a href="{{route('exam.alltest', ['id'=>$exam->id])}}" class="btn btn-info mr-1"> Xem điểm</a>
                                @endif
                            @endif
                        @else
                            <a href="#" class="btn btn-success mr-1"><i class="fas fa-cogs"></i> you must be it issuer of admin</a>
                        @endif

                        @if (Auth::user()->role->name == 'admin' || $exam->issuer_id == Auth::user()->id)
                            <form action="{{route('exam.delete', ['id' => $exam->id])}}" method="post">
                                @csrf
                                <button class="btn btn-danger mr-1" onclick="function(){$(this).find('form').submit();}"><i
                                        class="far fa-trash-alt"></i></button>
                            </form>
                        @endif

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 p-3 border-left">
            <h3>Thêm đề thi</h3>
            <div>
                <form action="/contest/detail/{{$contest->id}}/exam/add" method="post" id="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="examtime_at">Thời gian thi (phút)</label>
                                <input id="examtime_at" class="form-control" type="number" name="examtime_at">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="q_num">Số lượng câu hỏi</label>
                                <input id="q_num" class="form-control" type="number" name="q_num" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input id="q_mix" class="form-check-input" type="checkbox" name="q_mix" value="true">
                            <label for="q_mix" class="form-check-label">Trộn câu hỏi</label>
                        </div>
                        <div class="form-check">
                            <input id="a_mix" class="form-check-input" type="checkbox" name="a_mix" value="true">
                            <label for="a_mix" class="form-check-label">Trộn câu trả lời</label>
                        </div>
                    </div>
                    <div class="">
                        <div class="row theme_level">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="theme">Chủ đề</label>
                                    <select name="theme[]" id="theme" class="form-control">
                                        @foreach ($themes as $theme)
                                        <option value="{{$theme->id}}">{{ $theme->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="level">Độ khó</label>
                                    <select name="level[]" id="level" class="form-control">
                                        @foreach ($levels as $level)
                                        <option value="{{$level->id}}">{{ $level->difficult}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="q_num_per_theme_level">Số lượng</label>
                                    <input class="form-control q_num" type="number" name="q_num_per_theme_level[]"
                                        value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="exam_detail"></div>
                    <div class="">
                        <button class="btn btn-primary add_theme_level">Add more level</button>
                        <button class="btn btn-danger remove_theme_level">Remove level</button>
                    </div>
                    <div class="my-3">
                        <button class="btn btn-info add_exam">Create Exam</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

</div>
@endsection

@section('js-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js"
    integrity="sha512-laacsEF5jvAJew9boBITeLkwD47dpMnERAtn4WCzWu/Pur9IkF0ZpVTcWRT/FUCaaf7ZwyzMY5c9vCcbAAuAbg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        tinymce.init({
            selector: '#content'
        });

        function sum_q(){
            var sum_q = 0;
            $(".q_num").each(function(){
                sum_q += parseInt($(this).val());

            });
            $("#q_num").val(sum_q);
        }

        function check_num_q(){
            if($(".theme_level").length == 1)
                $(".remove_theme_level").attr("disabled", true);
            else
            $(".remove_theme_level").attr("disabled", false);
        }
        check_num_q();
        $(".add_theme_level").click(function(e){
            e.preventDefault();
            $(".theme_level").first().clone().appendTo("#exam_detail");
            sum_q();
            check_num_q();
        });
        $(".remove_theme_level").click(function(e){
            e.preventDefault();
            $(".theme_level").last().remove();
            sum_q();
            check_num_q();
        });
        $(document).on('change','.q_num',function()
        {
            sum_q();
        });

        $(".add_theme_level").click(function(){
            // console.log($(".q_num"))
        });

        $(".add_exam").click(function(e){
            e.preventDefault();
            if($("#q_num").val() == 0 || $("#q_num").val() == "");
            else
                $("#form").submit();
        })

        $(".init").click(function(e){
            e.preventDefault();
            $(this).closest("form").submit();
        })
    });
</script>
@endsection
