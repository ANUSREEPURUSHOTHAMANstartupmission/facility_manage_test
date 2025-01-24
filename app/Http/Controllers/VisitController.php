<?php

namespace App\Http\Controllers;

use App\Helpers\BookingHelper;
use App\Helpers\VisitHelper;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Holiday;
use App\Models\Location;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('role')->except('show'); 
    }

    public function show(Location $location, Request $request){

        $validated = $request->validate([
            'qty' => 'numeric|max:60'
        ]);

        $available = false; // ::TODO:: check availbility
        $rates = collect([]);

        $facilities = $location->facilities()->where('type', 'visit')->where('status', 'active')->get();

        $images = collect([]);

        foreach($facilities as $item){
            $images = $images->concat($item->images->pluck('image'));
        }

        if($request->input('date') && $request->input('qty')){
            $start_date = Carbon::parse($request->input('date'));
            $end_date = Carbon::parse($request->input('date').' 23:59');
            
            $available = VisitHelper::check_availability($location, $start_date, $end_date);

            if($available){
                $rates = $facilities->map(function($facility) use($request){
                    $rate = BookingHelper::calculate_rate($facility, $request->input('qty'));

                    return [
                        'id' => $facility->id,
                        'name' => $facility->name,
                        'rate' => $rate
                    ];

                });

            }

        }

        return view('visit', compact('location', 'images', 'facilities', 'available', 'rates' ));

    }

    public function store(Location $location, Request $request){

        $validated = $request->validate([
            'qty' => 'numeric|max:60'
        ]);

        $start_date = Carbon::parse($request->input('date'));
        $end_date = Carbon::parse($request->input('date').' 23:59');

        $available = VisitHelper::check_availability($location, $start_date, $end_date);

        if($available){

            $facility_ids = $request->input('facilities');

            $facilities = Facility::whereIn('id', $facility_ids)->get();

            $rates = $facilities->map(function($facility) use($request){
                $rate = BookingHelper::calculate_rate($facility, $request->input('qty'));

                return $rate;
            });

            $data = collect($facility_ids)->combine($rates)->map(function($item){
                return ['amount' => $item];
            });
            
            $booking = new Booking();
            $booking->user_id = auth()->user()->id;
            $booking->start = $start_date->toDateTimeString();
            $booking->end = $end_date->toDateTimeString();
            $booking->location_id = $location->id;
            $booking->type = "visit";
            $booking->visitor_count = $request->input('qty');
            $booking->save();

            $booking->facilities()->attach($data);

            return redirect()->route('booking.view', [$booking]);

        }
        else{
            return redirect()->back();
        }

    }
}
