<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamThemesController extends Controller
{
    //
    public function __construct()
    {
     $this->middleware('auth')   ;
    }
}
