<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;


class ExamDetailsController extends Controller
{
    //
    public function __construct()
    {
     $this->middleware('auth')   ;
    }

}
