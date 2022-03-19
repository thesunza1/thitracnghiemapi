@extends('layouts.default')

@section('style')
    <link rel="stylesheet" href=" {{ asset('css/contests/home.css') }}">
@endsection

@section('content')
    <div class="container">
        <br>
        <div class="header">
            <h1> Danh Sách Cuộc Thi </h1>
        </div>
        <br>
        <div class="row">
            @foreach ($contests as $contest)
                {{-- @foreach (App\Models\Exams::where('contest_id', $contest->contest_id)->get() as $exam) --}}
                    {{-- @if(App\Models\ExamStaffs::where('exam_id', $exam->id)->get()->count() !== 0) --}}
                {{-- @if ($contest->contest->exams->count() > 0)
                    @foreach ( $contest->contest->exams as $exam)

                    @if($exam->examstaffs->count() !== 0)
                        @php
                            $able = true;
                        @endphp
                        @break
                    @else
                        @php
                            $able = false;
                        @endphp
                    @endif
                @endforeach

                @else
                        @php
                            $able = true;
                        @endphp

                @endif --}}
                @if(true)
                    <div class="col-md-1"></div>
                    <div class="container-ct col-md-5">

                        <div class="container__text">
                            <h1>{{ $contest->contest->name }}</h1>
                            <div class="container__text__timing">
                                <div class="container__text__timing_time">
                                    <h2>Mã dề thi </h2>
                                    <p>{{ $contest->contest->id }}</p>
                                </div>
                                <div class="container__text__timing_time">
                                    <h2>Ngày thi</h2>
                                    <p> {{ date('d-m-Y H:i:s',$contest->contest->begintime_at) }}</p>
                                </div>
                                <div class="container__text__timing_time">
                                    <h2>Người tạo </h2>
                                    <p>{{ $contest->contest->staff->name }}</p>
                                </div>
                            </div>

                            <p>
                                {!! $contest->contest->content !!}
                            </p>
                            <div class="container__text__timing">

                                <div class="container__text__timing_time">
                                    <h2>Ngày tạo</h2>
                                    <p>{{ $contest->contest->created_at }}</p>
                                </div>
                                {{-- <div class="container__text__timing_time">
                                    <h2>chi nhánh thi</h2>
                                    <p>{{ $contest->contest->branch->name }}</p>
                                </div> --}}

                            </div>
                            <a class="btn" href="{{ route('exam.index', ['id' => $contest->contest->id]) }}"> Xem các bài thi </a>
                        </div>

                    </div>
                @endif
            @endforeach

        </div>
    </div>
@endsection

@section('js-content')
@endsection
