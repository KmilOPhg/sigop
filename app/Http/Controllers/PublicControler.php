<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicControler extends Controller
{
    public function index(){
        return view('auth/login');
    }
}
