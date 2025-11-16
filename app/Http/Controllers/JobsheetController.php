<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobSheetController extends Controller
{
    public function index()
    {
        return view('jobsheet.index');
    }
}
