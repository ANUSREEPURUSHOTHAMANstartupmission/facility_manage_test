<?php

namespace App\Helpers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Holiday;
use App\Models\Location;
use Carbon\Carbon;

class VisitHelper{

  public static function check_availability(Location $location, $start_date, $end_date){

    $start = $start_date->toDateTimeString();
    $end = $end_date->toDateTimeString();

    // dd($facility);
    $conflict = Booking::where(function ($query) use ($start, $end) {
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
                        ->where('status', '<>', 'cancelled')
                        ->where('location_id', $location->id)
                        ->where('type', 'visit')
                        ->count();

    return ($conflict ? false : true ) && self::not_holiday($start_date, $location) && self::checkTime($start_date, $location) ;
  }

  public static function not_holiday($date, $location){

    $today = Carbon::now();
    $not_holiday = Holiday::whereDate('date', $date)->orWhereDate('date', $today)->doesntExist();

    $weekOk = in_array($date->dayOfWeek, $location->availability ?? []);

    return $not_holiday && $weekOk;
  }

  public static function checkTime($date, $location){
    $today = Carbon::now();

    $is_before = $today->isBefore($date);

    $diff = $today->diffInDays($date);

    return $is_before && ($diff > 5);
  }

}