<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TanyaDokterController extends Controller
{
    public function index()
    {
        // Return view halaman tanya dokter
        return view('page.tanya-dokter.index'); 
    }
}