<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BookingHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUDController;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Rate;
use App\Models\Role;
use App\Models\User;
use App\Notifications\BookingApprovedNotification;
use App\Tables\Admin\BookingTable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Booking::class;
        $this->heading = "Bookings";
        $this->table = BookingTable::class;
        $this->view = 'admin.bookings';
    }

    public function create(Request $request){

        $facilities = Facility::where([['is_addon', false],['status','active']])->whereIn('location_id', auth()->user()->locations->pluck('id')->toArray())->get();
        $query = $request->query->all();

        $facility = null;

        if($request->input('facility')){
            $facility = Facility::find($request->input('facility'));
        }

        $available = false;
        $rate = 0;
        $hours = 0;
        $rate_data = null;

        if($facility && $request->input('date') && $request->input('time') && $request->input('duration')){
            $rate_data = Rate::where([['facility_id', $request->input('facility')],['id', $request->input('duration')]])->first();

            if($rate_data){
                $start_date = Carbon::parse($request->input('date') . ' ' . $request->input('time'));
                $end_date = $start_date->copy()->addHours($rate_data->hours);

                $available = BookingHelper::check_availability($facility, $start_date->toDateTimeString(), $end_date->toDateTimeString());

                if($available){
                    $hours = ceil($start_date->floatDiffInHours($end_date));
                    $rate = BookingHelper::calculate_rate($facility, $hours);
                }
            }
        }

        $user = null;

        if($request->input('email')){
            $user = User::where('email', $request->input('email'))->first();
        }

        return view('admin.bookings.create', compact('facilities', 'query', 'facility', 'available', 'rate', 'hours', 'rate_data', 'user'));
    }

    public function store(Request $request){

        $facility = Facility::findOrFail($request->input('facility'));
        
        $role = Role::where('name','startup')->first();

        $user = User::firstOrCreate(['email' => $request->input('email')], [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'organisation' => $request->input('organisation'),
            'category' => $request->input('category'),
            'uid' => $request->input('uid'),
            'role_id' => $role->id,
        ]);

        $start_date = Carbon::parse($request->input('date') . ' ' . $request->input('time'));
        $rate_data = Rate::findOrFail($request->input('duration'));
        $end_date = $start_date->copy()->addHours($rate_data->hours);

        $available = BookingHelper::check_availability($facility, $start_date->toDateTimeString(), $end_date->toDateTimeString());

        if($available){

            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->start = $start_date->toDateTimeString();
            $booking->end = $end_date->toDateTimeString();
            $booking->location_id = $facility->location_id;
            $booking->status = "requested";

            $booking->purpose = $request->input('purpose');
            $booking->participants = $request->input('participants');
            
            $booking->save();

            $hours = ceil($start_date->floatDiffInHours($end_date));
            $rate = BookingHelper::calculate_rate($facility, $hours);

            //calculate rate
            $booking->facilities()->attach([$facility->id => [ "amount" => $rate ]]);

            return redirect()->route('admin.bookings.show', [$booking]);

        }
        else{
            return redirect()->back();
        }
        
    }

    public function show(Booking $booking){
        $addons = Facility::where([['location_id', $booking->location_id]])->get();
        return view('admin.bookings.show', compact('booking', 'addons'));
    }

    public function validateUpdate($request, $item){
        $this->validateItem($request, [
            'discount' => 'required',
            'reason' => 'required' 
        ]);
    }

    public function updateData($request, $item)
    {
        return [
            "discount" => $request->input('discount'),
            "reason" => $request->input('reason'),
        ];
    }

    public function approve(Booking $booking){
        if($booking->status == "requested"){
            $booking->status = "approved";
            $booking->save();
            
            // ::TODO:: send notification to customer
            $user = $booking->user;
            $user->notify(new BookingApprovedNotification($booking));

            // ::TODO:: send notification to facility admins
            
            
            flash("Success|Booking approved successfully", "success");

        }
        elseif($booking->status == "approved"){
            $booking->status = "requested";
            $booking->save();

            flash("Success|Approval revoked successfully", "success");
        }
        else{
            flash("Error|Booking cannot be approved", "danger");
        }
        
        return redirect()->back();
    }

    public function attach(Booking $booking, Request $request){
        if($booking->status == "pending" || $booking->status == "requested"){
            $addon = Facility::findOrFail($request->input('addon'));

            $available = BookingHelper::check_availability($addon, $booking->start, $booking->end);

            // dd($addon, $available);

            if($available){

                $hours = BookingHelper::date_diff($booking->start, $booking->end);
                $rate = BookingHelper::calculate_rate($addon, $hours);

                $booking->facilities()->syncWithoutDetaching([$addon->id => [ "amount" => $rate ]]);

                flash("Success|Addon added successfully", "success");
            }
            else{
                flash("Error|Addon is not available during the selected period", "danger");
            }

        }
        else{
            flash("Error|Cannot attach facility from booking in processing", "danger");
        }

        return redirect()->back();
    }

    public function detach(Booking $booking, Facility $facility){
        if($booking->status == "pending" || $booking->status == "requested"){
            $booking->facilities()->detach($facility->id);
            flash("Success|Facility detached successfully", "success");
        }
        else{
            flash("Error|Cannot detach addon from booking in processing", "danger");
        }

        return redirect()->back();

    }

    public function cancel(Booking $booking){
        
        $booking->status = "cancelled";
        $booking->save();
        flash('Success|Booking Cancelled');
        return redirect()->back();
    
    }

}
