<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
  private $api;

  public function __construct()
  {
      $this->middleware('role'); 
      $this->api = new Api(config('razorpay.key'), config('razorpay.secret'));
  }

  public function view(Payment $payment){
    $order = $this->api->order->fetch($payment->razorpay_order_id);
    
    if( ($order['amount_paid']/100) == ($payment->amount + $payment->transaction) ){
      $payment->razorpay_payment_id = $payment->razorpay_order_id;
      $payment->status = 'paid';
      $payment->save();
    }

    if($payment->payable->balance == 0){
      $payment->payable->status = 'confirmed';
      $payment->payable->save();
    }

    return redirect()->route('admin.bookings.show', [$payment->payable]);

    // dd( $order['amount_paid']/100  , $payment->amount, $payment->transaction, $payment->amount + $payment->transaction );

  }

}