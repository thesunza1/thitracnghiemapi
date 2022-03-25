@extends('layouts.default')

@section('style')
{{-- css  --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<link href="{{ asset('css/staffs/home.css') }}" rel="stylesheet">
<link href="{{ asset('css/util.css') }}" rel="stylesheet">
<style>
    .table100 {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    #tablelayout {
        border-radius: 10px;
        box-shadow: 0px 1px 10px rgb(168, 168, 168);
        overflow: hidden;
    }
</style>
@endsection
@section('content')
@php
    date_default_timezone_set("Asia/Ho_Chi_Minh");
@endphp
<div class="limiter">
    <br>
    <div class="header-text">
        <h1> Kì thi : {{ $contest->name }} </h1>
    </div>
    <div class="container-table100">

        <div class="table100 ver2 m-b-110" style="min-width : 80%">

            <table id="tablelayout" data-vertable="ver2">
                <thead>
                    <tr class="row100 head">
                        <th class="column100 column1" data-column="column1">id</th>
                        <th class="column100 column2" data-column="column2">issuer maker</th>
                        <th class="column100 column3" data-column="column3">number of question</th>


                        <th class="column100 column7" data-column="column7">time</th>
                        {{-- <th class="column100 column4" data-column="column4">branch</th> --}}
                        <th class="column100 column8" data-column="column8">action</th>
                    </tr>

                </thead>


                <tbody>

                    @foreach ($exams as $exam)
                    <tr class="row100">
                        <td class="column100 column1" data-column="column1"><b>{{ $exam->id }}</b></td>
                        <td class="column100 column2" data-column="column2"><b>{{ $exam->staff->name }}</b></td>
                        <td class="column100 column3" data-column="column3">{{ $exam->questionnum }}</td>

                        <td class="column100 column7" data-column="column7">{{ $exam->examtime_at }}</td>
                        {{-- <td class="column100 column4" data-column="column4">{{ $exam->contest->branch->name }}</td> --}}
                        <td class="column100 column8 " data-column="column8">
                            {{-- {{dd(App\Models\ExamStaffs::where('staff_id', Auth::user()->id)->where('exam_id', $exam->id)->firt())}} --}}
                            @php
                                $exam_staff = App\Models\ExamStaffs::where('staff_id', Auth::user()->id)->where('exam_id', $exam->id);
                            @endphp
                            @if($exam_staff->count() > 0)
                                @if ($exam_staff->first()->point == '-1')
                                    @if (time() < $exam->contest->begintime_at)
                                    <a class="btn btn-warning mr-1 ud-btn" name="id" value='{{ $exam->id }}' href="#">
                                        chưa tới thời gian thi </i></a>
                                    @else
                                        <?php $exam_staff =  App\Models\ExamStaffs::where('exam_id', $exam->id)->first();?>
                                        @if($exam_staff->count() !== 0)
                                        <a class="btn btn-success mr-1 ud-btn" name="id" value='{{ $exam->id }}'
                                            {{-- href="{{route('exam.taking', ['id' => $exam->id])}}"> --}}
                                            href="{{route('exam.execute', ['id' => $exam->id])}}">
                                            @if($exam_staff->time_limit == null)
                                            bắt đầu thi </i>
                                            @else
                                            tiếp tục thi </i>
                                            @endif
                                        </a>
                                        @endif
                                    @endif
                                @else
                                    <a class="btn btn-info  mr-1 ud-btn" name="id" value='{{ $exam->id }}' href="{{route('exam.result', ['id' => $exam->id])}}">
                                        xem điểm  </i></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


</div>
@endsection

@section('js-content')
{{-- js --}}
@endsection
