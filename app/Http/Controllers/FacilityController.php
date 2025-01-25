<?php

namespace App\Http\Controllers;

use App\Helpers\BookingHelper;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Holiday;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('role')->except('show'); 
    }

    public function show(Facility $facility, Request $request){

        // $addons = [];
        $available = false; // ::TODO:: check availbility
        $rate = 0;
        $hours = 0;

        // dd($request->all());

        if($request->input('date') && $request->input('time') && $request->input('duration')){
            $start_date = Carbon::parse($request->input('date') . ' ' . $request->input('time'));
            $rate_data = Rate::findOrFail($request->input('duration'));
            $end_date = $start_date->copy()->addHours($rate_data->hours);

            $available = BookingHelper::check_availability($facility, $start_date->toDateTimeString(), $end_date->toDateTimeString()) && BookingHelper::not_holiday($start_date, $facility) && BookingHelper::checkTime($start_date, $facility) ;

            if($available){
                $hours = ceil($start_date->floatDiffInHours($end_date));
                $rate = BookingHelper::calculate_rate($facility, $hours);
            }

        }
        // if($facility){
        //     $facility = Facility::find($facility);
        //     return view('admin.calendar.details', compact('month', 'year', 'bookings', 'days', 'facility', 'empty'));
        // }

        // $facility_calendar = Facility::find($facility);
      
      
        $month = Carbon::now()->format('M'); // Current month (e.g., 01 for January)
        $year = Carbon::now()->format('Y'); // Current year (e.g., 2025)

        $start = Carbon::parse($month.' '.$year)->startOfMonth();
        $end = $start->copy()->endOfMonth()->endOfDay();

       
        $bookings = Booking::where('status','<>','cancelled')
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start', '>=', $start)
                    ->where('start', '<', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start', '<=', $start)
                    ->where('end', '>', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('end', '>', $start)
                    ->where('end', '<=', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start', '>=', $start)
                    ->where('end', '<=', $end);
                });
            })
            ->when($facility, function($query, $facility){
                $query->whereHas('facilities', function($q) use($facility){
                    $q->where('facility_id', $facility->id);
                });
            })
            ->orderBy('start')->get()
            ->groupBy([
                function($item){
                    return $item->facilities[0]->name."|".$item->facilities[0]->id;
                },
                function($item){
                    return (int) Carbon::parse($item->start)->format('d');
                }
            ]);

        // dd($bookings, $facility);

        $days = Carbon::parse($month." ".$year)->daysInMonth;

        $empty = Carbon::parse($month." ".$year)->firstOfMonth()->dayOfWeek;

        $month = $month ?? date('M');

        $holidays = Holiday::whereMonth('date', $start->month)
        ->whereYear('date', $start->year)
        ->get();

        return view('facility', compact('facility', 'available', 'rate', 'hours','month', 'year', 'bookings', 'days', 'empty','holidays'));
    }

    public function store(Facility $facility, Request $request){

        $start_date = Carbon::parse($request->input('date') . ' ' . $request->input('time'));
        $rate_data = Rate::findOrFail($request->input('duration'));
        $end_date = $start_date->copy()->addHours($rate_data->hours);

        $available = BookingHelper::check_availability($facility, $start_date->toDateTimeString(), $end_date->toDateTimeString()) && BookingHelper::not_holiday($start_date, $facility) && BookingHelper::checkTime($start_date, $facility) ;



        if($available){

            $booking = new Booking();
            $booking->user_id = auth()->user()->id;
            $booking->start = $start_date->toDateTimeString();
            $booking->end = $end_date->toDateTimeString();
            $booking->location_id = $facility->location_id;
            $booking->save();

            $hours = ceil($start_date->floatDiffInHours($end_date));
            $rate = BookingHelper::calculate_rate($facility, $hours);

            //calculate rate
            $booking->facilities()->attach([$facility->id => [ "amount" => $rate ]]);

            return redirect()->route('booking.view', [$booking]);

        }
        else{
            return redirect()->back();
        }
    }

}
