<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CRUDController;
use App\Models\Role;
use App\Models\Facility;
use App\Models\Location;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Tables\Admin\FacilityTable;
use App\Tables\Admin\FacilityUsers;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Http\Request;

class FacilityController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Facility::class;
        $this->heading = "Facilities";
        $this->table = FacilityTable::class;
        $this->view = 'admin.facilities';
    }


    public function create(){
        $locations = auth()->user()->locations;
        return view('admin.facilities.create', compact('locations'));
    }

    public function edit(Facility $facility){
        $locations = auth()->user()->locations;
        return view('admin.facilities.edit', compact('facility', 'locations'));
    }

    public function show(Facility $facility){
        //show startups of challenges
        $table = (new FacilityUsers($facility))->setup();

        $heading = "Facility: ".$facility->name;
        $subheading = "Users";

        return view('components.table-page', compact('table', 'heading', 'subheading'));
    }

    public function validateStore($request)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'qty' => "required",
            'location_id' => 'required|exists:locations,id',
            'brief' => 'required',
            'type' => 'required',
            'lead_time' => 'required',
        ]);
    }

    public function storeData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "description" => $request->input('description'),
            "is_addon" => $request->input('is_addon')?true:false,
            "status" => $request->input('status'),
            "qty" => $request->input('qty'),
            "location_id" => $request->input('location_id'),
            "brief" => $request->input('brief'),
            "type" => $request->input('type'),
            "availability" => $request->input('availability'),
            "lead_time" => $request->input('lead_time'),
        ];
    }

    public function validateUpdate($request, $item)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'qty' => "required",
            'location_id' => 'required|exists:locations,id',
            'brief' => 'required',
            'type' => 'required',
            'lead_time' => 'required',
        ]);
    }

    public function updateData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "description" => $request->input('description'),
            "is_addon" => $request->input('is_addon')?true:false,
            "status" => $request->input('status'),
            "qty" => $request->input('qty'),
            "location_id" => $request->input('location_id'),
            "brief" => $request->input('brief'),
            "type" => $request->input('type'),
            "availability" => $request->input('availability'),
            "lead_time" => $request->input('lead_time'),
        ];
    }

    public function assign(Facility $facility){
        return view('admin.facilities.assign', compact('facility'));
    }

    public function user(Facility $facility, Request $request){
        $request->validate([
            'user'=>'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->input('user'));

        $facility->users()->attach($user);

        flash("Success|User assigned successfully", "success");

        return redirect()->back();
    }

    public function detach(Facility $facility, User $user){
        $facility->users()->detach($user);
        flash("Success|User detached successfully", "success");

        return redirect()->back();
    }

}
