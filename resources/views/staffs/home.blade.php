@extends('layouts.default')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<link href="{{ asset('css/staffs/home.css') }}" rel="stylesheet">
<link href="{{ asset('css/util.css') }}" rel="stylesheet">
<style>
    .error-log {
        background: rgb(219, 88, 88, 97%);
        box-shadow: 0px 0px 4px rgb(219, 88, 88, 97%);
        /* border: 1px solid gray; */
        border-radius: 20px;
        display: block;
        width: 400px;
        padding: 30px;


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
        <h1> Danh Sách Nhân Viên</h1>

    </div>

    <div class="container-table100">
        @if (count($errors) > 0 )
        <div class="alert text-danger text-center error-log">
            @foreach($errors->all() as $value)
            <h5>{{ $value }}</h5>

            @endforeach
        </div>
        @endif



        <div class="table100 ver2 m-b-110">

            <table id="tablelayout" data-vertable="ver2">
                <thead>
                    <tr class="row100 head">
                        <th class="column100 column1" data-column="column1">id</th>
                        <th class="column100 column2" data-column="column2">email</th>
                        <th class="column100 column3" data-column="column3">name</th>
                        <th class="column100 column4" data-column="column4">phone number</th>
                        <th class="column100 column5" data-column="column5">address</th>
                        <th class="column100 column6" data-column="column6">branch</th>
                        <th class="column100 column7" data-column="column7">role</th>
                        <th class="column100 column8" data-column="column8">action</th>
                    </tr>

                </thead>


                <tbody>
                    <tr class="row100 ">
                        <td class="column100 column1" data-column="column1"></td>
                        <td class="column100 column2" data-column="column2"></td>
                        <td class="column100 column3" data-column="column3"></td>
                        <td class="column100 column4" data-column="column4"></td>
                        <td class="column100 column5" data-column="column5"></td>
                        <td class="column100 column6" data-column="column6"></td>
                        <td class="column100 column7" data-column="column7"></td>
                        <td class="column100 column8" data-column="column8">
                            <button class="btn btn-success mr-1 cr-btn" data-toggle='modal' data-target='#cr-modal'
                                name="id">
                                + Thêm nhân viên</button>
                        </td>
                    </tr>
                    @foreach ($staffs as $staff)
                    <tr class="row100">
                        <td class="column100 column1" data-column="column1"><b>{{ $staff->id }}</b></td>
                        <td class="column100 column2" data-column="column2"><b>{{ $staff->email }}</b></td>
                        <td class="column100 column3" data-column="column3">{{ $staff->name }}</td>
                        <td class="column100 column4" data-column="column4">{{ $staff->sdt }}</td>
                        <td class="column100 column5" data-column="column5">{{ $staff->address }}</td>
                        <td class="column100 column6" data-column="column6">{{ $staff->branch->name }}</td>
                        <td class="column100 column7" data-column="column7">
                            {{ $staff->role->name }}
                        </td>
                        <td class="column100 column8 " data-column="column8">
                            @if ($staff->id != Auth::user()->id)
                            <button class="btn btn-danger mr-1 cr-btn" data-toggle='modal' data-target='#dl-modal'
                                name="id" value='{{ $staff->id }}'>
                                <i class="fas fa-trash-alt"></i></button>
                            @endif

                            <button class="btn btn-warning mr-1 ud-btn" data-toggle="modal" data-target='#if-modal'
                                name="id" value='{{ $staff->id }}'>
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
                        <h5 class="ct-dl">you would delete staff it ?</h5>
                    </div>

                    <form action="{{ route('staff.drop') }}" method="post">
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
                    <h5 class="modal-title" id="if-modal-title">staff information </h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('staff.update') }}" method="post">
                        <div class="form-row">
                            @csrf
                            <input type="hidden" name="id" id="ud-id">
                            <div class="form-group col-md-6">
                                <label for="ud-email">Email</label>
                                <input name="email" type="email" class="form-control" id="ud-email" placeholder="Email"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ud-password">Password</label>
                                <input name="password" type="password" class="form-control" id="ud-password" required
                                    placeholder="Password">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="ud-name">name</label>
                                <input name="name" type="text" class="form-control" id="ud-name" required
                                    placeholder="tran manh quynh">
                            </div>
                            <div class="form-group col-md-7">
                                <label for="ud-sdt">number phone</label>
                                <input name="sdt" type="text" class="form-control" id="ud-sdt" placeholder="0123645349"
                                    required>
                            </div>
                            <div class="form-group col-md-5">

                                <label for="ud-address">address</label>
                                <input name="address" type="text" required class="form-control" id="ud-address"
                                    placeholder="long phuoc , vinh long">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-1"></div>
                            <div class="form-group col-md-4">
                                <label for="ud-branch">branch</label>
                                <select id="up-branch" name="branch" class="form-control">
                                    @foreach ($branchs as $branch)
                                    <option class="op-up-branch" value="{{ $branch->id }}">
                                        {{ $branch->name }}</option>
                                    @endforeach


                                </select>
                            </div>
                            <div class="form-group col-md-1"></div>
                            <div class="form-group col-md-4">
                                <label for="ud-role">role</label>
                                <select id="ud-role" name='role' class="form-control">
                                    @foreach($roles as $role)
                                    <option class="op-ud-md" value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-21"></div>
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
                    <h5 class="modal-title" id="cr-modal-title">staff information </h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('staff.create') }}" method="post">
                        <div class="form-row">
                            @csrf
                            {{-- <input type="hidden" name="id" id="cr-id"> --}}
                            <div class="form-group col-md-6">
                                <label for="cr-email"><b>Email</b></label>
                                <input name="email" type="email" class="form-control" id="cr-email" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cr-password"> <b>Password</b></label>
                                <input name="password" type="password" class="form-control" id="cr-password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="cr-name"><b>name</b></label>
                                <input name="name" type="text" class="form-control" id="cr-name"
                                    placeholder="tran manh quynh">
                            </div>
                            <div class="form-group col-md-7">
                                <label for="cr-sdt"><b>number phone</b></label>
                                <input name="sdt" type="text" class="form-control" id="cr-sdt" placeholder="0123645349">
                            </div>
                            <div class="form-group col-md-5">

                                <label for="cr-address"><b>address</b></label>
                                <input name="address" type="text" class="form-control" id="cr-address"
                                    placeholder="long phuoc , vinh long">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-1"></div>
                            <div class="form-group col-md-4">
                                <label for="cr-branch"><b>branch</b></label>
                                <select id="cr-branch" name="branch" class="form-control">
                                    @foreach ($branchs as $branch)
                                    <option class="op-cr-branch" value="{{ $branch->id }}">
                                        {{ $branch->name }}</option>
                                    @endforeach


                                </select>
                            </div>
                            <div class="form-group col-md-1"></div>
                            <div class="form-group col-md-4">
                                <label for="cr-role"><b>role</b></label>
                                <select id="cr-role" name='role' class="form-control">
                                    @foreach($roles as $role)
                                    <option class="op-ud-md" value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-21"></div>
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
                $.get("/staffs/show/" + ud_id, function(data) {
                    console.log(data);
                    $('#ud-id').val(data.id);
                    $('#ud-email').val(data.email);
                    $('#ud-name').val(data.name);
                    $('#ud-address').val(data.address);
                    $('#ud-sdt').val(data.sdt);
                    $('option.op-up-branch').each(
                        function(e) {
                            let op = $(this).val();
                            if (op == data.branch_id) {
                                $(this).attr('selected', 'selected');
                                return false;
                            }
                        }
                    );
                    $('op-ud-md').each(
                        function(e) {
                            let op = $(this).val();
                            if (op == data.role) {
                                $(this).attr('selected', 'selected');
                                return false;
                            }
                        }

                    )
                }, "JSON");
            });

            $('.cr-btn').click(function(e) {
                $('#id-cr-md').val($(this).val());

            });
            $('#tablelayout').DataTable();
        });
</script>


@endsection
