@extends('layouts.default')

@section('content')
<!-- Setup question -->
<h2 class="text-center pt-3" style="font-weight:500">Thêm câu hỏi</h2>
<div class="row m-0">
    <div class="col-md-12 text-center">
        <p class="wow fadeIn" data-wow-duration="2s">View your all questions here.</p>
    </div>
</div>
<form action="/question/create" method="post" id="create_form">
    @csrf
    <div class="container mt-5">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="topic">Chủ đề</label>
                <select name="topic" id="topic" class="form-control">
                    @foreach ($themes as $theme)
                        <option value="{{ $theme->id}}">{{$theme->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="topic">Độ khó</label>
                <select name="level" id="topic" class="form-control">
                    @foreach ($levels as $level)
                        <option value="{{ $level->id}}">{{$level->difficult }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="quantity">Số lượng câu hỏi</label>
                <input type="number" name="quantity" id="quantity" class="form-control border" min="0" max="5" placeholder="Số lượng từ 1 - 5">
            </div>
            <div class="form-group col-md-3">
                <label for="quantity">Generate</label>
                <button class="btn btn-info d-block" id="question_generator" style="height:38px;" onclick="event.preventDefault();"><i class="fas fa-plus"></i> Add Question</button>
            </div>
        </div>

    </div>
    <div class="container error" id="error">

    </div>
    <!-- Add question -->
    <div class="container" id="generated_question">
        <div id="order_questions"></div>
    </div>
</form>

<!-- Submit -->
<div class="container mt-3">
    <button class="btn btn-success" id="submit_question">Xác nhận thêm</button>
</div>
@endsection

@section('js-content')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    $(document).ready(function(){
        new WOW().init();
        var max_questions = 5;
        var questions = 0;
        var i = 1;
        var arr = ['0','A','B','C','D','E','F','G','H','I','J','K','L','M','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        //Set limit Number of questions for Generator
        var min = 1;
        var max = max_questions;
        $("#quantity").change(function(){
            var current = $("#quantity").val();
            if(current < min)
                $("#quantity").val(min);
            else if(current > max){
                $("#quantity").val(max);
            }
        });

        //Setup questions base on the input of number of questions
        $("#question_generator").click(function(){
            let quantity = parseInt($("#quantity").val());
            if(quantity > (max_questions - questions))
                quantity = (max_questions - questions);
            if(questions < max_questions && (questions + quantity <= max_questions)){
                questions += quantity;
                for(i; i <= questions; i++){
                    //button for each collapse
                    let btn_question = $("<button></button>")
                    .addClass("btn btn-primary btn-question")
                    .attr("data-toggle","collapse")
                    .attr("data-target","#my-collapse-"+i)
                    .attr("aria-expanded","true")
                    .attr("aria-controls","my-collapse")
                    .html("Câu " + i);

                    let dlt_question = $('<button>')
                    .addClass('btn btn-danger dlt-btn d-none')
                    .attr('data', i)
                    .html('X');

                    let question_div = $('<span>').addClass('mr-3').append(btn_question, dlt_question).appendTo("#order_questions");

                    //collapse part
                    let div = $("<div></div>").addClass("collapse p-3 mt-3 container").attr("id","my-collapse-"+i).css("box-shadow","0px 0px 3px grey").css("border-radius","3px");
                    let div2 = $("<div></div>").attr("id",i).addClass("q");
                    let tit = $("<h3><b>Câu " +i+ "</b></h3>");

                    let b_div = $("<div></div>").addClass("row").attr({id: "b_div"});
                    let button = $("<div>").addClass("pp").append($("<button></button>").addClass("btn btn-info btn-add").attr({id:'more_answer_'+ i}).html("Thêm đáp án"));
                    let question = $("<div></div>").addClass("form-group col-md-12").append($("<input>").attr("type","text").attr("name","question[]")
                    .attr("id","question"+i).attr("placeholder","Câu hỏi")
                    .addClass("form-control").css("background-color","#cfd4ff8f")
                    .attr("required", true)
                    .css("border-color","#629bd4")).appendTo($(b_div));

                    // generate 4 default question
                    var default_number = 4;
                    for(var j = 1; j <= default_number; j++)
                    {
                        let answer = $("<div></div>").addClass("form-group col-md-5");
                        let input = $("<input/>").attr("type","text").attr("name","answer["+i+"]["+j+"]")
                        // let input = $("<input/>").attr("type","text").attr("name","answer[][]")
                        .addClass("answer_"+i+" form-control answer")
                        .attr("id","answer_"+i+"_"+j).attr("placeholder","Đáp án "+ arr[j])
                        .css("background-color","#ddd").css("border-color","#629bd4")
                        ;
                        let delete_btn = $("<button></button>").addClass("btn text-danger border ml-1 btn-delete btn-delete-"+i).attr({id:i}).html("X").css("display","none");
                        let div = $("<div/>").addClass("d-flex").append(input, delete_btn);

                        let checkbox = $("<input/>").attr("type","checkbox").attr({name:"iscorrect["+i+"]["+j+"]", value:"true", id:"iscorrect["+i+"]["+j+"]"}).css({width:"20px", height:"20px", margin:"10px"});
                        let label = $("<label/>").attr({for:"iscorrect["+i+"]["+j+"]"}).html("Đúng").addClass("mb-0");
                        let correct_div = $("<div/>").addClass("d-flex align-items-center").append(checkbox, label)

                        $(answer).append(div, correct_div).appendTo($(b_div));
                    }

                    $(div).append($(div2).append(tit, b_div, button)).appendTo("#create_form");
                }
            }
            display_last_child_of_btn_delete();
            display_last_child_of_btn_delete_question();
            // Add more answer for each question
            $(document).on('click','.btn-add', function(){
                let a = $(this).closest(".collapse").find(".answer");
                let length = a.length + 1; // thứ tự của câu trả lời này
                let num_q = $(this).closest(".q").attr("id");// thuộc câu hỏi số [1]
                console.log(num_q);
                let id = "answer["+num_q +"]["+length+"]";
                let b = length - 1;

                let checkbox = $("<input/>").attr("type","checkbox").attr({name:"iscorrect["+num_q+"]["+length+"]", value:"true"}).css({width:"20px", height:"20px", margin:"10px"});
                let label = $("<label/>").attr({for:"iscorrect_"+j}).html("Đúng").addClass("mb-0");
                let correct_div = $("<div/>").addClass("d-flex align-items-center").append(checkbox, label)

                let input = $("<input>").attr("type","text").attr("name", id).attr("id",id).attr("placeholder","Đáp án "+arr[length]).addClass("answer_"+num_q + " form-control answer").css("background-color","#ddd").css('border-color','#629bd4');
                let delete_btn = $("<button></button>").addClass("btn text-danger border ml-1 btn-delete btn-delete-"+num_q).attr({id:num_q}).html("X").css("display","none");
                let f_div = $("<div/>").addClass("d-flex").append(input, delete_btn);

                let div = $("<div></div>").addClass("form-group col-md-5").append(f_div, correct_div);

                console.log($(this).closest("div").siblings("#b_div").append($(div)));
                display_last_child_of_btn_delete();
            });
        });

        // Submit forms of questions
        $("#submit_question").click(function(){
            var q_valid = true;
            var a_valid = true;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('input[name^="question"]').each(function(){
                // console.log($(this).val())
                if($(this).val() == ""){
                    q_valid = (q_valid && false);
                    $(this).addClass('border-danger');
                }
                else
                    q_valid = (q_valid && true);
            })
            $('input[name^="answer"]').each(function(){
                // console.log($(this).val())
                if($(this).val() == ""){
                    a_valid = (a_valid && false);
                    $(this).addClass('border-danger');
                }
                else
                    a_valid = (a_valid && true);
            })
            console.log(a_valid + "-" + q_valid);
            var error;
            let div = $("<div>").addClass('my-2');
            if(q_valid == false)
            {
                $("#topic").focus();
                div.append(
                    $("<span>").html("Xin kiểm tra lại CÂU HỎI")
                    .addClass('text-danger border border-danger p-1 rounded mb-1 mr-2 fadeOut')
                )
            }
            if(a_valid == false)
            {
                $("#topic").focus();
                div.append(
                    $("<span>").html("Xin kiểm tra lại CÂU TRẢ LỜI")
                    .addClass('text-danger border border-danger p-1 rounded mb-1 mr-2 fadeOut')
                )
            }
            if($("#quantity").val() == "")
            {
                $("#topic").focus();
                div.append(
                    $("<span>").html("Xin kiểm tra lại Số lượng câu hỏi")
                    .addClass('text-danger border border-danger p-1 rounded mb-1 mr-2 fadeOut')
                )
            }
            if(q_valid == false || a_valid == false || $("#quantity").val() == ""){
                $(".error").html(div);
                $(".fadeOut").fadeOut(3000);
            }
            else{
                $("#create_form").submit();
            }
        });
        $(document).on('click','input[name^="question"]', function(){
            $(this).removeClass('border-danger');
        });
        $(document).on('click','input[name^="answer"]', function(){
            $(this).removeClass('border-danger');
        });
        $(document).on('click','.btn-add',function(e){
            e.preventDefault();
        });
        $(document).on('click','.btn-question',function(e){
            e.preventDefault();
        });

        function display_last_child_of_btn_delete() {
            $(".q").each(function(){
                let id = $(this).attr("id");
                $(".btn-delete-"+id).css("display","none");
                $(".btn-delete-"+id).last().css("display","inline");
            });
        }

        $(document).on('click','.btn-delete', function(e){
            e.preventDefault();
            console.log($(this).parents(".form-group").remove());
            display_last_child_of_btn_delete();
            let id = $(this).attr("id");
            $(".answer_"+id).each(function(){
                console.log($(this).attr("placeholder"));
            })
        })

        /**
         *  Display th last button of delete question btn
         */
        function display_last_child_of_btn_delete_question(){
            $('.dlt-btn').each(function(){
                if(!$(this).hasClass('d-none')){
                    $(this).addClass('d-none');
                }
            })
            $('.dlt-btn').last().removeClass('d-none');
        }

        /**
         *  Delete question button on click
         */
        $(document).on('click','.dlt-btn', function(e){
            let id = $(this).attr('data');
            e.preventDefault();
            $(this).closest('span').remove();
            $('#my-collapse-'+id).remove();
            questions--;
            i--;
            display_last_child_of_btn_delete_question();
        })
    });
</script>
@endsection
