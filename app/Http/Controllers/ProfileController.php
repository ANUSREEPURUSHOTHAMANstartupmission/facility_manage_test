<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('role'); 
    }

    public function index(){
        $user = auth()->user();

        return view('profile', compact('user'));
    }

    public function store(Request $request){
        $request->validate([
            "name" => "required",
            "phone" => "required",
            "organisation" => 'required',
            "category" => 'required',
            "uid" => 'required_unless:category,associates',
        ]);

        $user = auth()->user();

        // dd($user);

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->organisation = $request->input('organisation');
        $user->category = $request->input('category');
        $user->uid = $request->input('uid');
        $user->save();

        flash("Success|Profile updated successfully", "success");

        return redirect()->back();

    }

}
