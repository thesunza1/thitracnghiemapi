<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>tttt</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- css -->
    <link rel="stylesheet" href="{{url('css/main.css')}}">
    <link rel="stylesheet" href="{{url('css/util.css')}}">
    <link rel="stylesheet" href="{{url('css/animate.css')}}">

    <!-- datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <?php date_default_timezone_set("Asia/Ho_Chi_Minh"); ?>

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial !important;
            background-color: rgb(255, 255, 255);
        }

        .container {
            max-width: 80% !important;
        }

        .btn:focus {
            box-shadow: none;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .link-text:hover {
            color: rgb(194, 188, 188) !important;
        }

        /* Dropdown Button */
        .dropbtn {
            font-size: 16px;
            border: none;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    @yield('style')
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm py-0">
        <div class="container" style="max-width: 80%;">
            {{-- <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a> --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand" href="{{ route('home')}}" style="width:20px; height: auto;"><img
                            src="https://image.shutterstock.com/image-vector/illustration-quiz-icon-on-white-600w-1129762556.jpg"
                            alt="" style="width:40px; height: auto;"></a>
                    <ul class="navbar-nav ml-5">

                        <li class="nav-item pt-1">
                            <a class="nav-link" href="{{ route('home') }}">Cuộc thi</a>
                        </li>
                        {{-- <li class="nav-item pt-1">
                            <a class="nav-link" href="#">My exams</a>
                        </li> --}}

                        @if ( Auth::user()->role_id !=1 )
                        <li class="nav-item pt-1">
                            <a class="nav-link" href="{{ route('questions')}}"> Câu hỏi</a>
                        </li>
                        <li class="nav-item pt-1">
                            <a class="nav-link" href="{{ route('contests')}}"> Quản lý cuộc thi</a>
                        </li>
                        @endif

                        @if (Auth::user()->role_id ==2 )
                        <li class="nav-item pt-1">
                            <a class="nav-link" href="{{ route('staff.index') }}"> Nhân viên</a>
                        </li>
                        <li class="nav-item pt-1">
                            <a class="nav-link" href="{{ route('branch.index') }}"> Phòng</a>
                        </li>
                        @endif



                    </ul>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')

</body>
<footer>
    <div class="text-white" style="background-color: black;position: relative;">
        <div class="container">
            <div class="my-3">
                <a href="#" class="text-decoration-none">Tên sản phẩm</a></div>
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <?php for($i=0;$i<4;$i++): ?>
                        <div class="col-md-3 d-flex flex-column">
                            <span style="font-weight:200; color : #eaedf1d9;">Product</span>
                            <a href="#" class="text-decoration-none link-text text-white"
                                style="font-weight:500">Updates</a>
                            <a href="#" class="text-decoration-none link-text text-white"
                                style="font-weight:500">Security</a>
                            <a href="#" class="text-decoration-none link-text text-white"
                                style="font-weight:500">Current Extension</a>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="ml-auto col-md-4">
                    <div>
                        <p style="font-weight:200">Try new products with first top-up</p>
                        <form action="#">
                            <div class="input-group bg-dark">
                                <input type="text" class="form-control" style="background-color: black;"
                                    placeholder="Enter Your Email">
                                <div class="input-group-append">
                                    <span class="btn btn-primary rounded">Get Started</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr style="background-color : #eaedf136; margin-top: 5px;">
            <span class="d-flex justify-content-between">
                <span>Sản phẩm của nhóm thực tập</span>
                <span>18/6/2021, Vị Thanh - VNPT Hậu Giang</span>
            </span>
        </div>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="{{url('js/wow.min.js')}}"></script>
@yield('js-content')

</html>
