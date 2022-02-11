@extends('layouts.default')

@section('style')

<style>
    .dataTable {
        /* border-radius: 15px; */
        box-shadow: 0px 0px 25px #dccccc;

    }
    .dataTable table {
        border-radius: 15px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div>
        <br>
        <h3 class="text-center">Danh sách câu hỏi</h3>
    </div>
    <div class="row m-0">
        <div class="col-md-12 col-md-offset-3 text-center">
            <p class="wow fadeIn" data-wow-duration="2s">View your all questions here.</p>
        </div>
    </div>
    <a href="/question/add" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Add Question</a>
    <div class="dataTable ">
        <table class="table table-striped table-bordered table-hover" id="question_list">
            <thead class="">
                <tr>
                    <th>Stt</th>
                    <th>Nội dung</th>
                    <th>Mức độ</th>
                    <th>Chủ đề</th>
                    <th>Người tạo</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($questions as $question)
                <tr>
                    <td style="text-align: center">{{$i++}}</td>
                    <td>{{$question->content}}</td>
                    <td>{{$question->level->difficult}}</td>
                    <td>{{$question->theme->name}}</td>
                    <td>{{$question->staff->name}}</td>
                    <td>{{$question->created_at}}</td>
                    <td class="d-flex">
                        <a href="#" class="btn btn-danger mr-1 delete" id="{{$question->id}}">
                            <i class="fas fa-trash-alt"></i></a>
                        {{-- <a href="/question/detail/{{$question->id}}"
                        class="btn btn-info mr-1 detail" id="{{$question->id}}">
                        <i class="fas fa-info-circle"></i></a> --}}
                        <a href="/question/edit/{{$question->id}}" class="btn btn-warning mr-1 edit" target="_blank"
                            id="{{$question->id}}">
                            <i class="fas fa-cog"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div id="question_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Bạn có chắc muốn xoá câu hỏi này ?</p>
                    <form action="" method="post">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="question_detail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <div>

    </div>

    <div class="d-flex flex-row-reverse py-3">
         {{ $questions->links() }}
    </div>

</div>

@endsection

@section('js-content')
<script>
    $(document).ready(function(){
        // $("#question_list").DataTable();
        // new WOW().init();
        //delete button interaction
        $(document).on('click','.delete', function(e)
        {
            // console.log("1");
            e.preventDefault();
            let id = $(this).attr("id");
            $("#question_delete").find("form").attr("action", "/question/delete/"+ id).append($("<button>").addClass("btn btn-danger").html('Xác nhận'))

            // $("#question_delete").find(".modal-body").append($(""), content);
            $("#question_delete").modal("show");
        });
        $(document).on('click','.modal-delete', function(e){
            e.preventDefault();
            $(this).closest('form').submit();
        });
        $("#question_delete").on('hide.bs.modal', function (){
            $("#question_delete").find(".modal-body").html('');
        });

        //info button interaction
        // $(document).on('click','.detail', function(e)
        // {
        //     e.preventDefault();
        //     let id = $(this).attr("id");
        //     // console.log(id);
        //     $.ajax({
        //         method: "GET",
        //         url: "/question/detail/"+id,
        //         dataType: 'json',
        //         success: function(msg){
        //             let arr = [];
        //             for(var j in msg){
        //                 arr.push(msg[j]);
        //             }
        //             // console.log(arr);
        //             let div = $("<div></div>").append(
        //                 $("<lable></lable>").html('Id'),
        //                 $("<div></div>").html(arr[0]).addClass('border border-dark rounded form-control'),
        //                 $("<lable></lable>").html('Content'),
        //                 $("<div></div>").html(arr[1]).addClass('border border-dark rounded p-1'),
        //                 $("<lable></lable>").html('Mức độ'),
        //                 $("<div></div>").html(arr[2]).addClass('border border-dark rounded form-control'),
        //                 $("<lable></lable>").html('Chủ đề'),
        //                 $("<div></div>").html(arr[3]).addClass('border border-dark rounded form-control'),
        //                 $("<lable></lable>").html('Người tạo'),
        //                 $("<div></div>").html(arr[4]).addClass('border border-dark rounded form-control'),
        //                 $("<lable></lable>").html('Ngày tạo'),
        //                 $("<div></div>").html(arr[5]).addClass('border border-dark rounded form-control'),
        //             );
        //             $("#question_detail").find('.modal-body').append($(div));
        //             $("#question_detail").modal('show');
        //         }
        //     });
        // });
        $("#question_detail").on('hide.bs.modal', function (){
            $("#question_detail").find(".modal-body").html('');
        });
    });
</script>
@endsection

