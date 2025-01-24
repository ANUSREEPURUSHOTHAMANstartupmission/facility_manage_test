<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginToken;
use App\Models\User;
use App\Rules\StrongPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function form(){
        return view('auth.login');
    }

    public function investor_page(){
        return view('auth.investor');
    }

    public function verify(Request $request, $token){
        $token = LoginToken::where('token', hash('sha256', $token))->firstOrFail();
        abort_unless($request->hasValidSignature() && $token->isValid(), 401);
        $token->consume();
        Auth::login($token->user, $remember = true);
        return redirect()->intended('/home');
    }

    public function authenticate(Request $request){

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if($user){
            $user->sendLoginToken();
            flash("Login Link has been send to your email", "success");
            return redirect()->back();
        }
        else{
            return redirect()->route('register', [ 'email' => $request->input('email') ]);
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        flash("Logged out successfully", "success");

        if($request->redirect){
            return redirect($request->redirect);
        }
        else{
            return redirect()->route('login');
        }
    }

}
