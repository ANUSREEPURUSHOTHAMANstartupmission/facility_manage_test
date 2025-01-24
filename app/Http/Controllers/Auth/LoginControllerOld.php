<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginUrlNotification;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginControllerOld extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if($user){
            $generator = new LoginUrl($user);
            // Override the default url to redirect to after login
            $to = explode('|',$user->role->type)[0];

            $generator->setRedirectUrl($request->input('url'));
            
            // if($to){
            //     $generator->setRedirectUrl('/'.$to); // Override the default url to redirect to after login
            // }
            // else{
            //     $generator->setRedirectUrl('/home');
            // }
            
            $url = $generator->generate();

            $user->notify(new LoginUrlNotification($url));

            flash("Login Link Send|Check your email inbox and click on the link to login.", "success");

            return redirect()->back();
        }
        else{
            flash("User not found|Please enter a email id registred in the portal", "danger");
            return redirect()->back();
        }

    }

    public function form_login(){
        if(request()->input('url')){
            $url = request()->input('url');
        }
        else {
            $url = url()->previous();
        }
        return view('auth.login', compact('url'));
    }  

    public function form(){
        $query = http_build_query([
            'client_id' => config('oauth.id'),
            'redirect_uri' => config('oauth.callback'),
            'response_type' => 'code',
            'register_url' => route('register')
        ]);
    
        return redirect(config('oauth.server').'/oauth/authorize?'.$query);
    }

    public function callback(Request $request){

        $response = Http::asForm()->post(config('oauth.server').'/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('oauth.id'),
            'client_secret' => config('oauth.secret'),
            'redirect_uri' => config('oauth.callback'),
            'code' => $request->code,
        ]);

        $data = $response->json();

        if(array_key_exists('access_token', $data)){

            $response = Http::withToken($data['access_token'])->get(config('oauth.server').'/api/user');

            $data = $response->json();

            if(array_key_exists('email', $data)){

                $user = User::where('email',$data['email'])->first();
                Auth::login($user, $remember = true);

                return redirect()->intended('home');

            }

        }
        
        return redirect()->route('register');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        flash('Logged out successfully');

        return redirect(config('oauth.server').'/logout');
    }
}
