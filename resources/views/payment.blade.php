@extends('layouts.main')

@section('style')
<style>
  .razorpay-payment-button{
    display: block;
    background: #206bc4;
    border:0;
    color: white;
    padding: .5rem 2rem;
    margin: 0 auto;
    transition: all 500ms ease;
  }
  .razorpay-payment-button:hover{
    background: #686de0;
    box-shadow: 2px 2px 5px rgba(0,0,0,.4);
  }
</style>
@endsection

@section('content')

<div class="flex-fill d-flex flex-column justify-content-center py-4 h-100" style="min-height: 100vh">
  <div class="container-tight py-6">
    <div class="text-center mb-4">
      <a href="."><img src={{asset("./img/logo.svg")}} height="100" alt=""></a>
    </div>
    <div class="card card-md">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Pay Now</h2>
        <div class="card card-sm">
          <div class="card-body">
            <div class="row g-2 align-items-center">
              <div class="col-auto">
                <div class="avatar bg-blue text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-rupee" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M18 5h-11h3a4 4 0 0 1 0 8h-3l6 6"></path>
                    <line x1="7" y1="9" x2="18" y2="9"></line>
                 </svg>
                </div>
              </div>
              <div class="col">
                <span class="font-weight-semibold">Rs. {{$payment->amount}}</span><br>
                <code>Rs.{{$payment->transaction}}</code>
              </div>
            </div>
          </div>
        </div>
        <form class="form-footer" action="{{route('payment.update',[$payment])}}" method="post">
          @php
            $f = $payment->payable->facilities->pluck('name')->toArray();
            $ftext = implode(", ", $f);
          @endphp
          @csrf
          @method('PUT')
          <script
              src="https://checkout.razorpay.com/v1/checkout.js"
              data-key="{{$rzrpay}}" 
              data-amount="{{ round($payment->amount + $payment->transaction, 2) * 100 }}" 
              data-currency="INR"
              data-order_id="{{$payment->razorpay_order_id}}"
              data-buttontext="Pay with Razorpay"
              data-name="Kerala Startup Mission"
              data-description="Facility Booking"
              data-image="{{asset('img/logo.svg')}}"
              data-prefill.name="{{$payment->payable->user->person}}"
              data-prefill.email="{{$payment->payable->user->email}}"
              data-prefill.contact="{{$payment->payable->user->phone}}"
              data-theme.color="#686de0"
              data-notes.start="{{ $payment->payable->start }}"
              data-notes.end="{{ $payment->payable->end }}"
              data-notes.facility="{{ $ftext }}"
          ></script>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
