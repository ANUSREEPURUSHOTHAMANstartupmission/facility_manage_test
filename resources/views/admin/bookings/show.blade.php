@extends('layouts.page')

@section('page')
    <x-page-header heading="Booking" subhead="Overview"></x-page-header>
    <div class="row row-deck row-cards">
      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Booking</h3>
          </div>
          <div class="card-body">
            <dl class="row">
              <dt class="col-5">Name:</dt>
              <dd class="col-7">{{$booking->user->name}}</dd>
              <dt class="col-5">Email:</dt>
              <dd class="col-7">{{$booking->user->email}}</dd>
              <dt class="col-5">Phone:</dt>
              <dd class="col-7">{{$booking->user->phone}}</dd>
              <dt class="col-5">Organisation:</dt>
              <dd class="col-7">{{$booking->user->organisation}}</dd>
              <dt class="col-5">Category:</dt>
              <dd class="col-7">{{$booking->user->category}}</dd>
              @if ($booking->user->uid)
                <dt class="col-5">Unique ID:</dt>
                <dd class="col-7">{{$booking->user->uid}}</dd>
              @endif
            </dl>
          </div>
          <div class="card-header">
            <h3 class="card-title">Details</h3>
          </div>
          <div class="card-body">
            @if($booking->type == "visit")
              <dl class="row">
                <dt class="col-5">Visit Date:</dt>
                <dd class="col-7">{{Carbon::parse($booking->start)->format('d M Y')}}</dd>
                <dt class="col-5">Visitor Count:</dt>
                <dd class="col-7">{{$booking->visitor_count}}</dd>
              </dl>
            @else
              <dl class="row">
                <dt class="col-5">Start:</dt>
                <dd class="col-7">{{Carbon::parse($booking->start)->toDayDateTimeString()}}</dd>
                <dt class="col-5">End:</dt>
                <dd class="col-7">{{Carbon::parse($booking->end)->toDayDateTimeString()}}</dd>
                <dt class="col-5">Hours:</dt>
                <?php
                  $hours = BookingHelper::date_diff($booking->start, $booking->end)
                ?>
                <dd class="col-7">{{ $hours }} Hours</dd>
              </dl>
            @endif
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header">
            <div class="col-sm-8">
              <h3 class="card-title">Booked Items</h3>
            </div>
            <div class="col-sm-4 text-right">
              @if ($booking->status == "pending" || $booking->status == "requested")
                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-team">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  Add Facility
                </a>
              @endif
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>Item</th>
                  {{-- <th class="text-center">Hours</th> --}}
                  <th class="text-right">Amount</th>
                  <th class="w-1"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($booking->facilities as $item)
                  <tr>
                    <td>{{$item->name}}</td>
                    {{-- <td class="text-center">{{$hours}} Hours</td> --}}
                    <td class="text-right">Rs. {{$item->pivot->amount}}</td>
                    <td class="w-1">
                      @if (($booking->status == 'pending' || $booking->status == 'requested'))
                        <a href="{{route('admin.bookings.detach', [$booking, $item])}}" class="btn btn-link">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="4" y1="7" x2="20" y2="7"></line>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                        </svg>
                        </a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-6">
                <b>Status: </b>
                <span 
                  class="badge 
                        {{$booking->status == "pending" ? "bg-red" : ""}}
                        {{$booking->status == "requested" ? "bg-azure" : ""}}
                        {{$booking->status == "approved" ? "bg-orange" : ""}}
                        {{$booking->status == "confirmed" ? "bg-green" : ""}}
                ">
                  {{$booking->status}}
                </span>
              </div>
              <div class="col-sm-6 text-right">
                <h1>Rs. {{$booking->total}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row mt-2 justify-content-end">
      <div class="col-sm-4">
        
        <div class="card mb-2">
          <div class="card-body">

            @if($booking->type == "visit")
              <div class="mb-3">
                <label class="form-label">Participant List</label>
                <div class="form-control-plaintext">
                  <a href="{{ Storage::url($booking->participants) }}" target="_blank">View List</a>
                </div>
              </div>
            @else
              <div class="mb-3">
                <label class="form-label">Purpose</label>
                <div class="form-control-plaintext">{{$booking->purpose}}</div>
              </div>
              <div class="mb-3">
                <label class="form-label">No. of Participant</label>
                <div class="form-control-plaintext">{{$booking->participants}}</div>
              </div>
            @endif

          </div>
        </div>

        @if ($booking->status == "requested" || $booking->status == "approved")
          <form class="card mb-2" action="{{route('admin.bookings.approve', [$booking])}}" method="POST">
            @csrf
            <div class="card-body">

              @if ($booking->requested)
                <div class="mb-3">
                  <label class="form-label">Requested Discount</label>
                  <div class="form-control-plaintext">{{$booking->requested}}</div>
                </div>
              @endif

              <div class="d-flex justify-content-center">
                <button type="submit" class="btn 
                  {{$booking->status == "requested"?"btn-success":''}}
                  {{$booking->status == "approved"?"btn-danger":''}}
                mx-auto">
                  {{$booking->status == "requested"?"Approve":''}}
                  {{$booking->status == "approved"?"Revoke":''}}
                </button>
              </div>
            </div>
          </form>

          <form class="card" action="{{route('admin.bookings.cancel', [$booking])}}" method="POST">
            @csrf
            <div class="card-body text-center">
              <button type="submit" class="btn btn-danger">Cancel</button>
            </div>
          </form>
        @endif

        @if($booking->status == "approved" || $booking->status=="confirmed")
          @if (count($booking->payments))
            <div class="card">
              <div class="card-header flex justify-content-between">
                <h4 class="card-title">Payments</h4>

                @if($booking->status == "confirmed")
                  <a href="{{route('booking.receipt', [$booking->id])}}" target="_blank" class="btn btn-success btn-sm">
                    View Invoice
                  </a>
                @endif  
              </div>

              
              <div class="table-responsive">
                <table class="table table-vcenter card-table">
                  <thead>
                    <tr>
                      <th class="text-center">Amount</th>
                      <th class="text-center">Transaction</th>
                      <th class="text-center">Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($booking->payments as $payment)
                      <tr>
                        <td class="text-center">Rs. {{$payment->amount}}</td>
                        <td class="text-center">Rs. {{$payment->transaction}}</td>
                        <td class="text-center">
                          <span 
                            class="badge 
                                  {{$payment->status == "pending" ? "bg-red" : ""}}                                    
                                  {{$payment->status == "paid" ? "bg-green" : ""}}
                          ">
                            {{$payment->status}}
                          </span>
                        </td>
                        <td class="text-right">
                          @if($payment->status == "pending")
                            <a href="{{route('admin.payments.view', [$payment->id])}}" class="btn btn-primary btn-sm">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                              </svg>
                            </a>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

            </div>
          @endif
        @endif

      </div>
      <div class="col-sm-4">
        <form class="card" action="{{route('admin.bookings.update',[$booking])}}" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">

            {{-- <label class="form-check">
              <input class="form-check-input" type="checkbox" {{$booking->requested?'checked':''}} id="request_discount">
              <span class="form-check-label">Provide Discount</span>
            </label> --}}

            @if($booking->requested)
              <div class="d-flex justify-content-end mb-3">
                <span class="badge bg-azure">Discount Requested</span>
              </div>
              <div class="text-sm text-right mb-3">{{$booking->requested}}</div>
            @endif
           
            <div id="request-form" class="">
              <div class="row align-items-center">
                <div class="col-5">
                  Discount %
                </div>
                <div class="col-7">
                  <input type="number" class="form-control" name="discount" id="disc_percent" {{$booking->status=="requested"?'':'disabled readonly'}} value="{{$booking->discount??0}}">
                  @error('discount')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            
              <div class="row align-items-center mt-2">
                <div class="col-5">
                  Discount Reason
                </div>
                <div class="col-7">
                  <input type="text" class="form-control" name="reason" {{$booking->status=="requested"?'':'disabled readonly'}} value="{{$booking->reason}}">
                  @error('reason')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-5">
                  Discount
                </div>
                <div class="col-7 mt-2">
                  <h4 class="card-title m-0 text-right" id="disc_value">Rs. {{$booking->discount_amount}}</h4>
                </div>
              </div>
            </div>
              <div class="row align-items-center mt-2">
                <div class="col-5">
                  Nett Total
                </div>
                <div class="col-7">
                  <h4 id="nett_total" class="card-title m-0 text-right">Rs. {{$booking->total - $booking->discount_amount}}</h4>
                </div>
              </div>

              <div class="row align-items-center mt-2">
                <div class="col-5">
                  Paid
                </div>
                <div class="col-7">
                  <h4 class="card-title m-0 text-right">Rs. {{$booking->paid}}</h4>
                </div>
              </div>

              <div class="row align-items-center">
                <div class="col-5">
                  Balance
                </div>
                <div class="col-7">
                  <h1 id="balance" class="text-right">Rs. {{$booking->balance}}</h1>
                </div>
              </div>

              <div class="d-flex">
                @if ($booking->status=="requested")
                  <button type="submit" class="btn btn-primary ms-auto">Save</button>
                @endif
              </div>
            
          </div>
        </form>
      </div>
      
    </div>

    
    <div class="modal modal-blur fade" id="modal-team" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" action="{{route('admin.bookings.attach', [$booking])}}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Add Facility</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

              @foreach ($addons as $addon)
                <label class="form-selectgroup-item flex-fill">
                    <input type="radio" name="addon" value="{{$addon->id}}" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div class="form-selectgroup-label-content d-flex align-items-center">
                            <div>
                            <div class="font-weight-medium">{{$addon->name}}</div>
                            </div>
                        </div>
                    </div>
                </label>
              @endforeach

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Addon</button>
          </div>
        </form>
      </div>
    </div>
    
  <script>
    // var total = {{$booking->total}};
    // var paid = {{$booking->paid}};
    // var discount_checkbox = document.getElementById('request_discount');
    // discount_checkbox.addEventListener('change', function(){
    //   document.getElementById('request-form').classList.toggle('visually-hidden');
    // });

    // var discount_percent = document.getElementById('disc_percent');
    // discount_percent.addEventListener('change', function(e){
    //   var percent = e.target.value;
    //   var discount = (total*percent)/100;
    //   var nett = total - discount;
    //   // console.log(percent, discount, nett);
    //   document.getElementById('disc_value').textContent = "Rs. " + discount;
    //   document.getElementById('nett_total').textContent = "Rs. " + nett;
    //   document.getElementById('balance').textContent = "Rs. " + (nett-paid);
    // });
  </script>
@endsection