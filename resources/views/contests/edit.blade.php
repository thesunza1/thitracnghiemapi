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
    <script>
        var arr = [];
    </script>
    <div class="container py-3">
        <form action="/contest/update/{{$contest->id}}" method="post">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="contest">Tên Kì Thi</label>
                        <input id="contest" class="form-control border" type="text" name="contest" value="{{$contest->name}}">
                    </div>
                    <div class="col-md-4">
                        <label for="begintime_at">Thời gian bắt đầu</label>
                        <input id="begintime_at" class="form-control border" type="datetime-local" name="begintime_at" value="{{date("Y-m-d\TH:i", $contest->begintime_at)}}">
                    </div>
                    <div class="col-md-4">
                        <label for="test_maker_id">Người ra đề</label>
                        <select name="test_maker_id" id="test_maker_id" class="form-control" readonly onclick='return false;'>
                            @foreach ($staffs as $staff)
                                @if ($contest->testmaker_id == $staff->id)
                                <option value="{{ $staff->id}}" selected>{{$staff->name }}</option>
                                @else
                                <option value="{{ $staff->id}}">{{$staff->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @if($exams = App\Models\Exams::where('contest_id', $contest->id)->get()->count() > 0)
                <p class="py-1"><strong class='text-info'>Trạng thái</strong> : Đã tạo đề mẫu</p>
                @foreach (App\Models\Exams::where('contest_id', $contest->id)->get() as $exam)
                    @if(App\Models\ExamStaffs::where('exam_id', $exam->id)->count() !== 0)
                        @php
                            $notice = "Ko thể thay đổi thí sinh(vì đã chia đề)";
                        @endphp
                        {{-- <p class='py-1'><strong class='text-danger'>Lưu ý</strong> : Ko thể thay đổi thí sinh(vì đã chia đề)</p> --}}
                        <?php $modifiable = 0; ?>
                        @break
                    @else
                        @php
                            $notice = "Có thể thay đổi thí sinh";
                        @endphp
                        {{-- <p class='p-1'>Lưu ý : Có thể thay đổi thí sinh</p> --}}
                        <?php $modifiable = true; ?>
                    @endif
                @endforeach
            <p class="p-1"><strong class='text-danger'>Lưu ý</strong> : {{$notice}}</p>
            @else
                <p class="p-2">Trạng thái : Chưa tạo đề mẫu</p>
                <p class='p-2'>Lưu ý : Có thể thay đổi thí sinh</p>
                <?php $modifiable = true; ?>
            @endif
            <div class="form-group">
                <div class='row'>
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
                                            <?php
                                                $contest_specials = App\Models\Contest_specials::where('contest_id', $contest->id)->where('staff_id', $staff->id)->count();
                                            ?>
                                                <div value="{{$staff->id}}" class='staff_name py-1' id='staff{{$staff->id}}'>
                                                    <span>{{$staff->name}}</span>
                                                    @if ($contest_specials != 0)
                                                        <script type='text/javascript'>
                                                            // var id = <?php echo $staff->id; ?>;
                                                            var id = {{$staff->id}};
                                                            arr.push(id);
                                                        </script>
                                                    @endif
                                                    <i class="fas fa-plus ml-5 text-success"></i>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group col-md-7 pl-4">
                        <label for="">Thí sinh <span class="badge badge-info"></span></label>
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
            </div>
            <div class="form-group">
                <label for="content">Text</label>
                <textarea name="content" id="content" cols="10" rows="10">{{$contest->content}}</textarea>
            </div>
            <div>
                <button class="btn btn-primary form-control">Thay đổi</button>
            </div>
        </form>
    </div>
@endsection

@section('js-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js" integrity="sha512-laacsEF5jvAJew9boBITeLkwD47dpMnERAtn4WCzWu/Pur9IkF0ZpVTcWRT/FUCaaf7ZwyzMY5c9vCcbAAuAbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        // tiny editor for textarea
        tinymce.init({
            selector: '#content'
        });

        var modifiable = {{$modifiable}};

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

        //change number of selected staff into badge
        function check_selected_item(){
            if($('.item').length){
                $('.badge').html($('.item').length);
            }else{
                $('.badge').html('0');
            }
        }
        check_selected_item();

        //submit form
        $("#contest_create").click(function(){
            $("#create_form").submit();
        });

        // change icon and expand col branch
        function expand_branch_col(e){
            $(this).find('.staff').toggleClass('d-none');
            $(this).find('.caret').toggleClass('fa-caret-left fa-caret-down');
        }
        $('.branch').on('click', expand_branch_col);

        //check all staff from selected branch
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

        //uncheck all staff from selected branch
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

        /**
         *  +select staff and add staff_name to selected_staff field
         *  +change icon
         *
         *  -and vice versa
         */
        function staff_name_on_click(e){
            e.stopPropagation();
            let check = true;
            let count = 0;
            let now = $(this);
            let id = $(this).attr('value');
            let name = $(this).find('span').html();
            if($(this).find('i').hasClass('fa-plus')){
                let template = $('.selected_staff_item').clone()
                .removeClass('selected_staff_item').addClass('item col-md-4 m-0 p-1 item'+id);
                $(template).find('input').attr({value: id, id: id})
                $(template).find('label').html(name + '(' + id + ')').addClass('pl-1');
                $(template).appendTo('.selected_staff');
            }
            else if($(this).find('i').hasClass('fa-minus')){
                $('.item'+id).remove();
                check = false;

            }
            $(this).find('.fas').toggleClass('fa-plus fa-minus text-danger text-success');
            if($(this).find('.fas').hasClass('fa-minus')){
                count++;
            }
            if($(now).siblings('.staff_name').length){
                $(now).siblings('.staff_name').each(function(){
                    if($(this).find('.fas').hasClass('fa-minus')){
                        check = check && true;
                        count++;
                    }
                    else{
                        check = check && false;
                        // count--;
                    }
                });
            }

            check_selected_item();
            $(now).parents('.branch').find('.ratio').html(count);
            (check)
            ? $(now).parents('.branch').find('.all-belong-to-branch').addClass('btn-all')
            : $(now).parents('.branch').find('.all-belong-to-branch').removeClass('btn-all');
        }
        $('.staff_name').on('click', staff_name_on_click);

        /**
         *  Trigger click event on item of Array 'arr'
         *
         *  Arr array is array of selected_staff that exist in Database
         **/
        for(var i in arr){
            $('#staff'+arr[i]).click();
        }
        $('.staff_name').off('click');

        /**
         *  allow modify selected_staff field
         **/
        if(modifiable){
            // bind event
            $('.staff_name').on('click', staff_name_on_click);
            $('.all-belong-to-branch').on('click', all_branch);
            $('.none-belong-to-branch').on('click', none_branch);

            /**
             *  Deselect selected_staff from selected_staff field
             *  And trigger staff_name click event following by id
             **/
            $(document).on('click', '.item', function(){
                $(this).find('input').attr('checked', false);
                let id = $(this).find('input').attr('value');
                $('#staff'+id).click();
            })
        }
    });
</script>
@endsection
