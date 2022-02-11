@extends('layouts.default')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<link href="{{ asset('css/branchs/home.css') }}" rel="stylesheet">
<link href="{{ asset('css/util.css') }}" rel="stylesheet">
<style>
    .error-log {
        background: rgb(219, 88, 88, 97%);
        box-shadow: 0px 0px 4px rgb(219, 88, 88, 97%);
        /* border: 1px solid gray; */
        border-radius: 20px;
        display: block;
        width: 500px;
        padding: 30px;
        height: 200px;
        left: 30%;
    }



    .error-log h5 {
        color: white !important;
    }
</style>
@endsection

@section('content')

<div class="limiter">
    <br>
    <div class="header-text">
        <h1>chi nhánh </h1>
    </div>
    <div class="container-table100">

        <div class="table100 ver2 m-b-110">
            @if (count($errors) > 0 )
            <div class="alert text-danger text-center error-log">
                @foreach($errors->all() as $value)
                <h5>{{ $value }}</h5>

                @endforeach
            </div>
            @endif
            <table id="tablelayout" data-vertable="ver2">
                <thead>
                    <tr class="row100 head">
                        <th class="column100 column1" data-column="column1">id</th>
                        <th class="column100 column5" data-column="column5">name</th>
                        <th class="column100 column6" data-column="column6">address</th>
                        <th class="column100 column7" data-column="column7">borth</th>
                        <th class="column100 column8" data-column="column8">action</th>
                    </tr>

                </thead>


                <tbody>
                    <tr class="row100 ">
                        <td class="column100 column1" data-column="column1"></td>
                        <td class="column100 column5" data-column="column5"></td>
                        <td class="column100 column6" data-column="column6"></td>
                        <td class="column100 column7" data-column="column7"></td>
                        <td class="column100 column8" data-column="column8">
                            <button class="btn btn-success mr-1 cr-btn" data-toggle='modal' data-target='#cr-modal'
                                name="id">
                                + add branch</button>
                        </td>
                    </tr>
                    @foreach ($branchs as $branch)
                    <tr class="row100">
                        <td class="column100 column1" data-column="column1"><b>{{ $branch->id }}</b></td>
                        <td class="column100 column5" data-column="column5">{{ $branch->name }}</td>
                        <td class="column100 column6" data-column="column6">{{ $branch->address }}</td>
                        <td class="column100 column7" data-column="column7">
                            {{ $branch->created_at }}

                        </td>
                        <td class="column100 column8 " data-column="column8">

                            @if (Auth::user()->branch_id != $branch->id)
                            <button class="btn btn-danger mr-1 cr-btn" data-toggle='modal' data-target='#dl-modal'
                                name="id" value='{{ $branch->id }}'>
                                <i class="fas fa-trash-alt"></i></button>
                            @endif

                            <button class="btn btn-warning mr-1 ud-btn" data-toggle="modal" data-target='#if-modal'
                                name="id" value='{{ $branch->id }}'>
                                <i class="fas fa-cog"></i></button>
                        </td>
                    </tr>

                    @endforeach


                </tbody>
            </table>

        </div>
    </div>
    <div id="dl-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading"> delete</h4>
                        <br>
                        <h5 class="ct-dl">you would delete branch it ?</h5>
                    </div>

                    <form action="{{ route('branch.drop') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id-cr-md">

                        <button href="#" class="btn btn-danger float-right" type="submit">delete</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div id="if-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="if-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered if-ct-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="if-modal-title">branch information </h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('branch.update') }}" method="post">
                        <div class="form-row">
                            @csrf
                            <input type="hidden" name="id" id="ud-id">
                            <div class="form-group col-md-5">
                                <label for="ud-name">name</label>
                                <input name="name" type="text" class="form-control" id="ud-name" required
                                    placeholder="tran manh quynh">
                            </div>
                            <div class="form-group col-md-5">

                                <label for="ud-address">address</label>
                                <input name="address" type="text" required class="form-control" id="ud-address"
                                    placeholder="long phuoc , vinh long">
                            </div>
                            <div class="form-group col-md-5">

                                <label for="ud-created">created_at</label>
                                <input name="created" type="datetime-local" required class="form-control"
                                    id="ud-created">
                            </div>


                        </div>
                        <button type="submit" class="btn btn-primary float-right mr-5">change it</button>


                    </form>
                </div>
                <div class="modal-footer">
                    Footer
                </div>
            </div>
        </div>
    </div>


    <div id="cr-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cr-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered cr-ct-md" role="document">
            <div class="modal-content">
                <div class="modal-header cr-hd-md">
                    <h5 class="modal-title" id="cr-modal-title">branch information </h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('branch.create') }}" method="post">
                        <div class="form-row">
                            @csrf
                            {{-- <input type="hidden" name="id" id="cr-id"> --}}
                            <div class="form-group col-md-5">
                                <label for="cr-name">name</label>
                                <input name="name" type="text" class="form-control" id="cr-name" required
                                    placeholder="ten chi nhanh ">
                            </div>
                            <div class="form-group col-md-5">

                                <label for="cr-address">address</label>
                                <input name="address" type="text" required class="form-control" id="cr-address"
                                    placeholder="anywhere">
                            </div>
                            <div class="form-group col-md-5">

                                <label for="cr-created">created_at</label>
                                <input name="created" type="datetime-local" min='1999-06-21T08:23'
                                    max='2099-06-21T08:23' required class="form-control" id="cr-created">
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary float-right mr-5">add it</button>


                    </form>
                </div>
                <div class="modal-footer cr-ft-md">
                    Footer
                </div>
            </div>
        </div>
    </div>



</div>





@endsection


@section('js-content')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>


<script>
    //update modal
        $(document).ready(function() {
            $('.ud-btn').click(function(e) {
                let ud_id = $(this).val();
                $.get("/branchs/show/" + ud_id, function(data) {
                    console.log(data);
                    $('#ud-id').val(data.id);
                    $('#ud-name').val(data.name);
                    $('#ud-address').val(data.address);

                    let d = data.created_at;


                    console.log(d.slice(0,d.length-8));

                    $('#ud-created').val(d.slice(0,d.length-11));

                }, "JSON");
            });

            $('.cr-btn').click(function(e) {
                $('#id-cr-md').val($(this).val());

            });
            $('#tablelayout').DataTable();

        });
</script>


@endsection
