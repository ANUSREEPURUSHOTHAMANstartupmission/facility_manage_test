<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Facility;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('role'); 
    }

    public function index(Request $request){

        $month = $request->input('month');
        $year = $request->input('year');
        $facility = $request->input('facility');

        $start = Carbon::parse($month.' '.$year)->startOfMonth();
        $end = $start->copy()->endOfMonth()->endOfDay();

        $bookings = Booking::where('status','<>','cancelled')->whereIn('bookings.location_id',auth()->user()->locations->pluck('id')->toArray())
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
                                $q->where('facility_id', $facility);
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
        
        $days = Carbon::parse($month." ".$year)->daysInMonth;

        $empty = Carbon::parse($month." ".$year)->firstOfMonth()->dayOfWeek;

        $month = $month ?? date('M');
        
        if($facility){
            $facility = Facility::find($facility);
            return view('admin.calendar.details', compact('month', 'year', 'bookings', 'days', 'facility', 'empty'));
        }
        else{
            return view('admin.calendar.list', compact('month', 'year', 'bookings', 'days'));
        }
    }
}
