<?php

namespace App\Helpers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Holiday;
use Carbon\Carbon;

class BookingHelper{

  public static function date_diff($start, $end){
    $start_date = Carbon::parse($start);
    $end_date = Carbon::parse($end);
    $diff = ceil($start_date->floatDiffInHours($end_date));

    return $diff;
  }

  public static function div_rate($rates, $value){
    $result = 0;
    foreach($rates as $rate){
        $result += floor($value/$rate->hours) * $rate->rate;
        $value = ($value%$rate->hours);
    }
    if($value>0){
        $result += $rate->rate;
    }
    return $result;
  }

  public static function calculate_rate(Facility $facility, $diff){

    $rates_desc = $facility->rates()->orderBy('hours', 'DESC')->get();
    $rates_asc =  $facility->rates()->orderBy('hours')->get();
    
    $result = 0;

    foreach($rates_asc as $rate){
        if($diff<=$rate->hours){
            $result = $rate->rate;
            break;
        }
    }

    if($result == 0){
        $result = self::div_rate($rates_desc, $diff);
    }

    return $result;
  }

  public static function check_availability(Facility $facility, $start, $end){

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
                        ->whereHas('facilities', function($query) use($facility){
                            $query->where('id', $facility->id);
                        })
                        ->count();

    // dd($conflict);
    return ($conflict<$facility->qty?true:false);

  }

  public static function not_holiday($date, $facility){

    $today = Carbon::now();
    $not_holiday = Holiday::whereDate('date', $date)->orWhereDate('date', $today)->doesntExist();

    $weekOk = in_array($date->dayOfWeek, $facility->availability ?? []);
    $weekOkToday = in_array($today->dayOfWeek, $facility->availability ?? []);

    return $not_holiday && $weekOk && $weekOkToday;
  }

  public static function checkTime($date, $facility){
    $today = Carbon::now();

    $is_before = $today->isBefore($date);

    $diff = $today->floatDiffInHours($date);

    return $is_before && ($diff > $facility->lead_time);
  }

}