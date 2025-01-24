<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUDController;
use App\Models\Location;
use App\Models\User;
use App\Tables\Admin\LocationTable;
use App\Tables\Admin\LocationUsers;
use Illuminate\Http\Request;

class LocationController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Location::class;
        $this->heading = "Locations";
        $this->table = LocationTable::class;
        $this->view = 'admin.locations';
    }


    public function create(){
        $districts = ['Alappuzha', 'Ernakulam', 'Idukki','Kannur','Kasaragod','Kollam','Kottayam','Kozhikode','Malappuram','Palakkad','Pathanamthitta','Thiruvananthapuram','Thrissur','Wayanad']; 
        return view('admin.locations.create', compact('districts'));
    }

    public function edit(Location $location){        
        $districts = ['Alappuzha', 'Ernakulam', 'Idukki','Kannur','Kasaragod','Kollam','Kottayam','Kozhikode','Malappuram','Palakkad','Pathanamthitta','Thiruvananthapuram','Thrissur','Wayanad']; 
        return view('admin.locations.edit', compact('location', 'districts'));
    }

    public function show(Location $location){
        //show startups of challenges
        $table = (new LocationUsers($location))->setup();

        $heading = "Location: ".$location->name;
        $subheading = "Users";

        return view('components.table-page', compact('table', 'heading', 'subheading'));
    }

    public function validateStore($request)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'map' => 'required',
            'district' => 'required'
        ]);
    }

    public function storeData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "map" => $request->input('map'),
            "district" => $request->input('district'),
            "availability" => $request->input('availability'),
        ];
    }

    public function validateUpdate($request, $item)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'map' => 'required',
            'district' => 'required'
        ]);
    }

    public function updateData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "map" => $request->input('map'),
            "district" => $request->input('district'),
            "availability" => $request->input('availability'),
        ];
    }


    public function assign(Location $location){
        return view('admin.locations.assign', compact('location'));
    }

    public function user(Location $location, Request $request){
        $request->validate([
            'user'=>'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->input('user'));

        $location->users()->attach($user);

        flash("Success|User assigned successfully", "success");

        return redirect()->back();
    }

    public function detach(Location $location, User $user){
        $location->users()->detach($user);
        flash("Success|User detached successfully", "success");

        return redirect()->back();
    }
}
