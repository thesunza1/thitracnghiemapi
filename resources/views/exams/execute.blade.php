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
              {{ ++$sttq}}  {{$q->question->content }}
            </div>
            <br>
            <div >
                @foreach ($q->question->relies as $sttr => $r)
                @if ( $q->question->num_chose->num == 1)
                <input type="radio" value="{{ $r->id  }}" {{ $sttr == 1 ? 'checked' : ''  }} class="d-inline" name="chose{{  $sttq  }}[]" style="margin-left: 10px" /> <label
                    class="d-inline">{{++$sttr }} -
                    {{$r->noidung }} <br></label>
                @else
                <input type="checkbox" value="{{ $r->id }}" checked=" {{   true    }}" class="d-inline"
                    style="margin-left: 10px" /> <label class="d-inline">{{++$sttr }} - {{$r->noidung }} <br></label>
                @endif
                @endforeach

            </div>
            @endforeach

        </div>

    </div>
</div>

@endsection


@section('js-content')

@endsection
