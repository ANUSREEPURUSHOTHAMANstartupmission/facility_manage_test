<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CRUDController;
use App\Models\Role;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Tables\Admin\UsersTable;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = User::class;
        $this->heading = "Users";
        $this->table = UsersTable::class;
        $this->view = 'admin.users';
    }

    public function create(){
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function edit(User $user){
        $roles = Role::all();
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function validateStore($request)
    {
        $this->validateItem($request, [
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "phone" => "required",
            "status" => "required",
            "role_id" => "required|exists:roles,id",
        ]);
    }

    public function storeData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "phone" => $request->input('phone'),
            "status" => $request->input('status'),
            "role_id" => $request->input('role_id'),
        ];
    }

    public function storeAdvanced($item, $request)
    {
        $query = http_build_query([
            'name' => $item->name,
            'email' => $item->email,
        ]);

        $response = Http::get(config('oauth.server').'/register/'.config('oauth.id').'/user?'.$query);
        // $generator = new LoginUrl($item);
        // $generator->setRedirectUrl('/home'); // Override the default url to redirect to after login
        // $url = $generator->generate();

        // $item->notify(new WelcomeNotification($url));
    }

    public function validateUpdate($request, $item)
    {
        $this->validateItem($request, [
            "name" => "required",
            "email" => "required|email|unique:users,email,".$item->id,
            "phone" => "required",
            "status" => "required",
            "role_id" => "required|exists:roles,id",
        ]);
    }

    public function updateData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "phone" => $request->input('phone'),
            "status" => $request->input('status'),
            "role_id" => $request->input('role_id'),
        ];
    }

    public function updateAdvanced($item, $request)
    {
        $query = http_build_query([
            'name' => $item->name,
            'email' => $item->email,
        ]);

        $response = Http::get(config('oauth.server').'/register/'.config('oauth.id').'/user?'.$query);
    }

    public function resend(User $user){
        $generator = new LoginUrl($user);
        $generator->setRedirectUrl('/home'); // Override the default url to redirect to after login
        $url = $generator->generate();

        $user->notify(new WelcomeNotification($url));

        flash("Notification send Successfully", "success");

        return redirect()->back();
    }

    public function search(Request $request){
        if($request->input('initial')){
            return User::select('id','name')->where('id', $request->input('initial'))->get();
        }
        
        if($request->input('query')){
            return User::select('id','name')->where('name', 'LIKE', '%'.$request->input('query').'%')->limit(10)->get();
        }

        return User::select('id','name')->limit(10)->get();

    }
}
