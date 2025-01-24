<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StartupIndiaController extends Controller
{
    public function login_form(){
        return view('auth.silogin');
    }

    public function callback(Request $request){
        dd($request->all());
    }
}
