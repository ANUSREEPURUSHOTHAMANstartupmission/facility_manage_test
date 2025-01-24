<?php

namespace App\Http\Controllers;

use App\Helpers\BookingHelper;
use App\Helpers\VisitHelper;
use App\Models\Booking;
use App\Models\Facility;
use App\Notifications\BookingRequestNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class BookingController extends Controller
{

    public function __construct()
    {
        $this->middleware('role'); 
    }

    public function index(Booking $booking){
        //receipt
        if($booking->status == "confirmed" || $booking->status == "approved"){
            // return view('booking_receipt', compact('booking'));

            $pdf = Pdf::loadView('booking_receipt', compact('booking'));
            $pdf->showImageErrors = true;
            $pdf->SetProtection(['print'], '', config('app.key'));
            return $pdf->stream('document.pdf');
        }
        else{
            abort(403);
        }
    }

    public function store(Booking $booking, Request $request){
        if($booking->status == "pending"){
            $addon = Facility::findOrFail($request->input('addon'));

            if($booking->type == "visit"){
                $available = true;
            }
            else{
                $available = BookingHelper::check_availability($addon, $booking->start, $booking->end);
            }

            if($available){

                if($booking->type == "visit"){
                    $rate = BookingHelper::calculate_rate($addon, $booking->visitor_count);
                }
                else{
                    $hours = BookingHelper::date_diff($booking->start, $booking->end);
                    $rate = BookingHelper::calculate_rate($addon, $hours);
                }

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

    public function show(Booking $booking){

        if($booking->user_id == auth()->user()->id){
            //::TODO:: Check availability

            if($booking->type == "visit"){
                $facility_ids = $booking->facilities->pluck('id');

                $addons = Facility::where([['location_id', $booking->location_id],['type', 'visit']])->whereNotIn('id', $facility_ids)->get();
            }
            else{
                $addons = Facility::where([['location_id', $booking->location_id],['is_addon', true]])->get();
            }

            return view('booking_details', compact('booking', 'addons'));
        }
        else{
            abort(401);
        }

    }

    public function update(Booking $booking, Request $request){

        $booking->status = "requested";
        
        if($booking->type == "visit"){

            $request->validate([
                'file' => 'required|mimetypes:text/csv,text/plain'
            ]);

            $path = $request->file('file')->store('list');

            $booking->participants = $path;

        }
        else{
            $booking->requested = $request->input('request');
            $booking->purpose = $request->input('purpose');
            $booking->participants = $request->input('participants');
        }
        
        $booking->save();

        //::TODO:: send notification to location manager
        $users = $booking->location->users;
        Notification::send($users, new BookingRequestNotification($booking));

        flash("Request Submitted|You can make payment after admin confirms request", "success");

        return redirect()->back();
    }

    public function destroy(Booking $booking, Facility $facility){
        if($booking->status == "pending"){
            $booking->facilities()->detach($facility->id);
            flash("Success|Facility detached successfully", "success");
        }
        else{
            flash("Error|Cannot detach addon from booking in processing", "danger");
        }

        return redirect()->back();

    }

    

}
