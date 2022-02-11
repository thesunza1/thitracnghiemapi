@extends('layouts.default')

@section('style')
<style>
    body {
        background: whitesmoke ;
    }
</style>
@endsection


@section('content')
<div class="container">
    <h3 class="text-center pt-4">Danh sách dự thi</h3>
    <div class="row pt-4">
        <table class="table">
            <?php $i = 1; ?>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>id</th>
                    <th>họ tên</th>
                    <th>điểm thi </th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$exam->id}}</td>
                        <td>{{$exam->staff->name}}</td>
                        <td>
                            @if($exam->point == '-1')
                               chưa thi
                            @else
                               {{ $exam->point }}
                            @endif
                        </td>
                        <td><a href="/test/{{$exam->id}}" class="btn btn-success">
                            <i class="fas fa-sign-in-alt"></i> Đi đến
                        </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('js-content')

@endsection
