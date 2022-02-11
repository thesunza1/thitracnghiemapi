@extends('layouts.default')

@section('style')
    <style>
        .branch_name {
            background-color: rgb(235, 235, 235);
            max-height: 300px;
            overflow-y: scroll;
        }
        .branch:hover{
            background-color: rgb(255, 234, 112);
        }
        .all-belong-to-branch:hover{
            cursor: pointer;
            background-color: rgb(86, 255, 108);
        }
        .none-belong-to-branch:hover{
            cursor: pointer;
            background-color: rgb(255, 103, 82);
        }
        .all-belong-to-branch, .none-belong-to-branch{
            font-weight: 700;
        }
        .staff_name:hover{
            background-color: rgb(96, 158, 250);
        }
        .staff{
            background-color: rgb(199, 191, 191);
        }
        .bg-green{
            background-color: green;
        }
        .bg-red{
            background-color: red;
        }
        .item:hover{
            background-color: rgb(224, 223, 223);
        }
        .btn-all{
            background-color: rgb(255, 64, 64);
            color: white;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <h2 class="text-center my-3">Tạo kì thi</h2>
    <div class="d-flex">
        <div class="col-md-3 p-0 mb-5">
        <a href="{{route('contests')}}" class="btn btn-success form-control">Danh sách kì thi</a></div>
    </div>
    <form action="/contest/create" method="post" id="create_form">
        <div class="row">
            @csrf
            <div class="form-group col-md-5">
                <label for="contest">Kì thi</label>
                <input type="text" name="contest" id="contest" class="form-control border" placeholder="Tên kì thi..." >
            </div>
            <div class="form-group col-md-4">
                <label for="begin_time">Thời gian bắt đầu</label>
                <input type="datetime-local" name="begin_time" id="begin_time" class="form-control border">
            </div>
            <div class='col-md-12 row'>
                <div class="form-group col-md-5 pr-0">
                    <label for="">Chi nhánh</label>
                    <div class="border rounded branch_name">
                        @foreach ($branchs as $branch)
                            <div>
                                <div class='branch py-2'>
                                    <div class='pb-1'>
                                        <span class='p-2'>{{$branch->name}}</span>
                                        <span class='p-1 border border-danger rounded all-belong-to-branch'>ALL</span>
                                        <span class='p-1 border border-danger rounded none-belong-to-branch'>NONE</span>
                                        <span class='pl-5'><span class='ratio'>0</span>/{{$branch->staffs->count()}}</span>
                                        <i class="fas fa-caret-left float-right pr-2 caret"></i>
                                    </div>
                                    <div class='text-center staff d-none'>
                                        @foreach ($branch->staffs as $staff)
                                            <div value="{{$staff->id}}" class='staff_name py-1' id='staff{{$staff->id}}'>
                                                <span>{{$staff->name}}</span>
                                                <i class="fas fa-plus ml-5 text-success"></i>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group col-md-5 pl-4">
                    {{-- <label for="">Thí sinh <span class="badge"></span></label> --}}
                    <button type="button" class="btn btn-primary">
                        Thí sinh <span class="badge badge-light">4</span>
                      </button>
                    <div class='border selected_staff row'>
                    </div>
                    <div class="d-none">
                        <div class="form-group d-flex align-items-center selected_staff_item">
                            <input type="checkbox" name='staff_name[]' value="" checked>
                            <label for="" class='m-0'></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="content">Ghi chú</label>
                <textarea name="content" id="content" cols="10" rows="10" class="form-control"></textarea>
            </div>
        </div>
    </form>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-md-2 my-4">
            <button class="btn btn-primary form-control" id="contest_create">Tạo</button>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js" integrity="sha512-laacsEF5jvAJew9boBITeLkwD47dpMnERAtn4WCzWu/Pur9IkF0ZpVTcWRT/FUCaaf7ZwyzMY5c9vCcbAAuAbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            //set min of begin_date as today
            function set_today_as_min(){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                var h = today.getHours();
                var m = today.getMinutes();
                if(dd<10){
                        dd='0'+dd
                    }
                    if(mm<10){
                        mm='0'+mm
                    }

                today = yyyy+'-'+mm+'-'+dd+'T00:00';
                $("#begin_time").attr("min", today);
                console.log(today);
            }
            set_today_as_min();
            function check_selected_item(){
                if($('.item').length){
                    $('.badge').html($('.item').length);
                    console.log($('.item').length);
                }else{
                    $('.badge').html('0');
                    console.log($('.item').length);
                }
            }
            check_selected_item();
            $("#contest_create").click(function(){
                $("#create_form").submit();
            });

            tinymce.init({
                selector: '#content'
            });
            function expand_branch_col(e){
                $(this).find('.staff').toggleClass('d-none');
                $(this).find('.caret').toggleClass('fa-caret-left fa-caret-down');
            }

            $('.branch').on('click', expand_branch_col);

            $('.staff_name').click(function(e){
                e.stopPropagation();
                let check = true;
                let count = 0;
                let now = $(this);
                let id = $(this).attr('value');
                let name = $(this).find('span').html();
                if($(this).find('i').hasClass('fa-plus')){
                    let template = $('.selected_staff_item').clone()
                    .removeClass('selected_staff_item').addClass('item col-md-3 m-0 p-1 item'+id);
                    $(template).find('input').attr({value: id, id: id})
                    $(template).find('label').html(name).addClass('pl-1');
                    $(template).appendTo('.selected_staff');
                    count++;
                }
                else if($(this).find('i').hasClass('fa-minus')){
                    $('.item'+id).remove();
                    check = false;
                }
                $(this).find('.fas').toggleClass('fa-plus fa-minus text-danger text-success');
                if($(now).siblings('.staff_name').length){
                    $(now).siblings('.staff_name').each(function(){
                        // console.log($(this));
                        if($(this).find('.fas').hasClass('fa-minus') && $(now).find('.fas').hasClass('fa-minus')){
                            check = check && true;
                            count++;
                        }
                        else{
                            check = check && false;
                        }
                    });
                }
                check_selected_item();
                $(now).parents('.branch').find('.ratio').html(count);
                (check)
                ? $(now).parents('.branch').find('.all-belong-to-branch').addClass('btn-all')
                : $(now).parents('.branch').find('.all-belong-to-branch').removeClass('btn-all');
            });
            //check all staff of this branch
            function all_branch(e){
                e.stopPropagation();
                let check = true;
                let now;
                $(this).parents('.branch').find('.staff_name').each(function(){
                    now = $(this);
                    if($(this).find('.fas').hasClass('fa-plus')){
                        check = check && true;
                        $(now).click();
                    }else{
                        check = check && false;
                    }
                });
                $(now).parents('.branch').find('.all-belong-to-branch').addClass('btn-all')
            }

            //uncheck all staff of this branch
            function none_branch(e){
                e.stopPropagation();
                let check = true;
                let now;
                $(this).parents('.branch').find('.staff_name').each(function(){
                    now = $(this);
                    if($(this).find('.fas').hasClass('fa-minus')){
                        check = check && true;
                        $(now).click();
                    }else{
                        check = check && false;
                    }
                });
                $(now).parents('.branch').find('.all-belong-to-branch').removeClass('btn-all');
            }

            // bind event
            $('.all-belong-to-branch').on('click', all_branch);
            $('.none-belong-to-branch').on('click', none_branch);

            $(document).on('click', '.item', function(){
                $(this).find('input').attr('checked', false);
                let id = $(this).find('input').attr('value');
                $('#staff'+id).click();
                // console.log(id);
            })
        });
    </script>
@endsection
