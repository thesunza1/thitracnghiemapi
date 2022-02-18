@extends('layouts.default')

@section('style')

@endsection

@section('content')
<div class="">
    <div>
        <br>
        <h3 class="text-center">Danh sách Kì thi</h3>
    </div>
    <div class="container pl-5">
        <a href="{{route('contest.add')}}" class="btn btn-success"><i class="fas fa-plus"></i> Thêm Cuộc thi</a>
    </div>
<div class="limiter">
    <div class="container-table100 " style="background-color: whitesmoke !important;">
        <div class="table100 ver2 m-b-110 container" >
            <table data-vertable="ver2" id="contest_list">
                <thead>
                    <tr class="row100 head">
                        <th class="column100 column1 pl-4" data-column="column1">Id</th>
                        <th class="column100 column2 pl-4" data-column="column2">Tên Kì thi</th>
                        <th class="column100 column3 pl-4" data-column="column3">Người ra đề</th>
                        <th class="column100 column4 pl-4" data-column="column4">Thời gian bắt đầu</th>
                        {{-- <th class="column100 column5 pl-4" data-column="column5">Chi nhánh thi</th> --}}
                        <th class="column100 column6 pl-4" data-column="column6">Ngày tạo</th>
                        <th class="column100 column7 pl-4" data-column="column7">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($contests as $contest)
                    <tr class="row100">
                        <td class="column100 column1" data-column="column1">{{$i++}}</td>
                        <td class="column100 column2" data-column="column2">{{$contest->name}}</td>
                        <td class="column100 column3" data-column="column3">{{$contest->staff->name}}</td>
                        <td class="column100 column4" data-column="column4">
                            {{date('d-m-Y H:i:s',$contest->begintime_at)}}</td>
                        {{-- <td class="column100 column5" data-column="column5">...</td> --}}
                        <td class="column100 column6" data-column="column6">{{$contest->created_at}}</td>
                        <td class="column100 column7 px-2" data-column="column7">
                            <div class="d-flex">
                                @if (Auth::user()->role->name =='admin' || $contest->testmaker_id == Auth::user()->id )
                                <a href="/contest/delete/{{$contest->id}}" class="btn btn-danger mr-1"><i
                                        class="fas fa-trash-alt"></i></a>
                                <a href="/contest/edit/{{$contest->id}}" class="btn btn-warning mr-1"><i
                                        class="fas fa-cog"></i></a>
                                @endif

                                <a href="/contest/detail/{{$contest->id}}" class="btn btn-info mr-1"><i
                                        class="fas fa-info-circle"></i></a>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
@endsection

@section('js-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        $("#contest_list").DataTable();
    });
</script>
@endsection
