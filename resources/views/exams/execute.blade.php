@extends('layouts.default')


@section('style')

@endsection

@section('content')
<div class="limiter row w-100">
    <div class="col-md-3"></div>
    <div class="col-md-7">
        <div>
            @foreach($dt as $sttq => $q)
            <div class="mb-2">
                {{ ++$sttq}} {{$q->question->content }}
            </div>
            <br>
            <div class="input-group">
                @foreach ($q->question->relies as $sttr => $r)
                @if ( $q->question->num_chose->num == 1)
                <input type="radio" onclick="check( {{ $r->id }} , ' ')" value="{{ $r->id  }}" {{ array_search( "$r->id"
                    , $exam_choses) == '' ? '' : 'checked' }} class="d-inline" name="chose{{ $sttq }}[]"
                style="margin-left: 10px">
                <label class="d-inline"> {{++$sttr }} -
                    {{$r->noidung }} <br /></label>
                @else
                <input type="checkbox" onclick="check( {{ $r->id }}  , ' ')" value="{{ $r->id }}" class="d-inline"
                    style="margin-left: 10px" {{ array_search( "$r->id" , $exam_choses) == '' ? '' : 'checked' }}>
                <label class="d-inline"> {{++$sttr }} - {{$r->noidung }}
                    <br /></label>
                @endif
                @endforeach
            </div>
            @endforeach

        </div>

    </div>
</div>

@endsection


@section('js-content')
<script>
    var examStaffId = {{ $exam_staff->id }};
    var csrf = " {{csrf_token()  }}";
    function check(rely_id, check) {
    let checkData = {
        _token : csrf ,
        rely_id : rely_id,
        examStaffId: examStaffId,
        check: check,
    };
    $.post('{{ route('question.chose') }}', checkData  , function( res ) {
     console.log(res);
    }, 'json');
}


</script>

@endsection
