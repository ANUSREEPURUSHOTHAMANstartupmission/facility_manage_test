<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function form(Request $request){
        $email = $request->input('email');
        return view('auth.register', compact('email'));
    }

    public function success(){
        return view('auth.success');
    }

    public function register(Request $request){
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email",
            "phone" => "required",
            "organisation" => 'required',
            "category" => 'required',
            // "uid" => 'required',
        ]);

        $user = new User();

        $role = Role::where('name', 'startup')->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->organisation = $request->input('organisation');
        $user->category = $request->input('category');
        $user->uid = $request->input('uid');
        $user->role_id = $role->id;
        $user->save();

        $user->sendLoginToken();
        flash("Login Link has been send to your email", "success");
        
        return redirect()->route('login');

    }
}
