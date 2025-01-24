<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Notifications\FacilityBookedNotification;
use App\Notifications\PaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->middleware('role'); 
        $this->api = new Api(config('razorpay.key'), config('razorpay.secret'));
    }

    public function store(Booking $booking){
        // $total = $booking->facilities()->sum('amount');
        // $discount = ($total * ($booking->discount??0))/100;
        // $payment_initiated = $booking->payments()->sum('amount');
        
        $balance = $booking->balance - $booking->payments_initiated;

        $fees = $balance * 2.42 / 100;

        $amount = round($balance + $fees, 2) * 100;

        $razorpay_order = $this->api->order->create([
            'receipt'         => 'BK:'.$booking->id,
            'amount'          => $amount, // amount in the smallest currency unit
            'currency'        => 'INR',
            'payment_capture' =>  '1'
        ]);

        $payment = new Payment();
        $payment->payable_id = $booking->id;
        $payment->payable_type = Booking::class;
        $payment->amount = $balance;
        $payment->transaction = $fees;
        $payment->razorpay_order_id = $razorpay_order->id;
        $payment->save();

        return redirect()->route('payment.show', [$payment]);

    }

    public function show(Payment $payment){
        $rzrpay = config('razorpay.key');
        return view('payment', compact('payment', 'rzrpay'));
    }

    public function update(Payment $payment, Request $request){
        $this->api->utility->verifyPaymentSignature($request->except(['_token','_method']));
        $payment->razorpay_payment_id = $request->input('razorpay_payment_id');
        $payment->razorpay_signature = $request->input('razorpay_signature');
        $payment->status = 'paid';
        $payment->save();

        if($payment->payable->balance == 0){
            $payment->payable->status = 'confirmed';
            $payment->payable->save();

            //::TODO:: Notifiation
            $users = $payment->payable->location->users;
            Notification::send($users, new PaymentNotification($payment));

            //:: Notifiaction to facility manager
            $fusers = $payment->payable->facilities->map(function($facility){
                return $facility->users;
            })->flatten()->pluck('email')->unique();

            if($fusers->count())
                Notification::route('mail', $fusers)->notify(new FacilityBookedNotification($payment->payable));

            $payment->payable->user->notify(new FacilityBookedNotification($payment->payable));
        }

        return redirect()->route('booking.view', [$payment->payable]);
    }

}
