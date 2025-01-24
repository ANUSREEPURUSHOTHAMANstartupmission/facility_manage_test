@extends('layouts.page')

@section('page')
    <x-page-header heading="Booking" subhead="Overview"></x-page-header>
    <div class="row row-deck row-cards justify-content-end">
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
              <h3 class="card-title">Items</h3>
            </div>
            <div class="col-sm-4 text-right">
              {{-- @if ($booking->status == "pending")
                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-team">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  Addon
                </a>
              @endif --}}
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
                      @if (($item->is_addon == true || $booking->type == "visit") && $booking->status == 'pending')
                        <a href="{{route('booking.detach', [$booking, $item])}}" class="btn btn-link">
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

              {{-- Addons --}}
              @if ($booking->status == "pending" && count($addons) > 0)

                <thead>
                  <tr>
                    <th >
                      <b>Select Additional {{ $booking->type == "visit" ? 'Locations' : 'Addons' }} required:</b>
                    </th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($addons as $addon)
                    <tr>
                      <td >
                        {{$addon->name}}
                      </td>
                      <td class="text-right">
                        <form action="{{route('booking.attach', [$booking])}}" method="POST">
                          @csrf
                          <input type="hidden" name="addon" value="{{$addon->id}}" >
                          <button type="submit" class="btn btn-warning btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <line x1="12" y1="5" x2="12" y2="19"></line>
                              <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Add {{ $booking->type == "visit" ? "Location" : "Addon" }}
                          </button>
                        </form>
                      </td>
                      <td></td>
                    </tr>
                  @endforeach
                </tbody>

              @endif
              {{-- end addon section --}}

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

      
      @if ($booking->status == "pending")
        
          <div class="col-sm-4">
            <div class="card">
              <div class="card-body">
                <form class="row justify-content-end" action="{{route('booking.request', [$booking])}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="col-sm-12" x-data="{open: {{$booking->requested?'true':'false'}} }">        

                    @if($booking->type == "visit")
                      <x-input-file label="List of Visitors" name="file" ></x-input-field> 
                      <div class="small italics">List should container Name, Email, Phone number of individual visitors</div>                 
                    @else
                      <label class="form-check">
                        <input class="form-check-input" type="checkbox" {{$booking->requested?'checked':''}} id="request_discount" x-model="open">
                        <span class="form-check-label">Request Discount</span>
                      </label>
                      
                      <template x-if="open==true">
                        <div id="request-form">
                          <x-select-field label="Reason for Discount" name="request" placeholder="Enter reason for discount" value="{{$booking->requested}}">
                            <option value="" selected disabled>--select--</option>
                            <option >Incubated Startup</option>
                            <option >Incubators/ Community Partners</option>
                            <option >Govt Departments, Agencies</option>
                          </x-input-field>                  
                        </div>
                      </template>

                      <x-textarea name="purpose" label="Purpose" placeholder="Enter Purpose of booking" value="{{$booking->purpose}}"></x-textarea>
                      <x-input-field label="Number of Participants" type="number" name="participants" placeholder="Enter number of participants" value="{{$booking->participants}}"></x-input-field>                  
                    @endif

                  </div>
                  <div class="col-sm-12 text-right">
                    <button class="btn btn-success" type="submit">
                      Request Booking
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <line x1="13" y1="18" x2="19" y2="12"></line>
                        <line x1="13" y1="6" x2="19" y2="12"></line>
                      </svg>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        
      @elseif($booking->status == "requested")
        @if ($booking->requested)
          <p>
            Requested Discount: {{$booking->requested}}
          </p>
        @endif
      @endif
      

      @if ($booking->status == "pending" || $booking->status == "requested")
        <div class="col-sm-12">
          <div class="alert alert-danger ms-auto" role="alert">
            <div class="d-flex">
              <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M12 9v2m0 4v.01"></path>
                  <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                </svg>
              </div>
              <div>
                <h4 class="alert-title">You will be able to make the payment only after the Administrator approves your booking.</h4>
                <h4 class="alert-title">Your booking will be valid only after successfull payment.</h4>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>

    <div class="row mt-2 justify-content-end">

      @if($booking->status == "approved" || $booking->status=="confirmed")
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header flex justify-content-between">
              <h4 class="card-title">Payments</h4>

              @if($booking->status == "confirmed")
                <a href="{{route('booking.receipt', [$booking->id])}}" target="_blank" class="btn btn-success btn-sm">
                  View Invoice
                </a>
              @endif
            </div>

            @if (count($booking->payments))
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
                          @if($payment->status == 'pending')
                            <a href="{{route('payment.show', [$payment])}}" class="btn btn-primary btn-sm">
                              Pay Now
                            </a>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif

            @if($booking->status == "approved")
              <div class="card-body">
                <div class="alert alert-danger ms-auto" role="alert">
                  <div class="d-flex">
                    <div>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 9v2m0 4v.01"></path>
                        <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                      </svg>
                    </div>
                    <div>
                      <h4 class="alert-title">Your booking will be valid only after successfull payment.</h4>
                    </div>
                  </div>
                </div>
              </div>
            @endif

            
            @if($booking->payments_initiated < $booking->balance)
              <div class="card-body">
                <form action="{{route('booking.payment.create', [$booking])}}" method="POST">
                  @csrf
                  <button class="btn btn-success" type="submit">Make Payment</button>
                </form>
              </div>
            @endif  
            
          </div>
        </div>
      @endif

      <div class="col-sm-4">
        <div class="card">
          <div class="table-responsive">
            <table class="table card-table table-vcenter">
              
              @if($booking->discount>0)
                <tr>
                  <td>Discount:</td>
                  <td class="text-right">Rs. {{$booking->discount_amount}}</td>
                </tr>
                <tr>
                  <td>Nett Total:</td>
                  <td>
                    <h4 class="card-title m-0 text-right" >Rs. {{$booking->total - $booking->discount_amount}}</h4>
                  </td>
                </tr>
              @endif

              <tr>
                <td>Paid:</td>
                <td class="text-right">Rs. {{$booking->paid}}</td>
              </tr>

              <tr>
                <td>Balance:</td>
                <td>
                  <h1 class="m-0 text-right">Rs. {{$booking->balance}}</h1>
                </td>
              </tr>

            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- @if ($booking->status == 'pending')
      <div class="modal modal-blur fade" id="modal-team" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form class="modal-content" action="{{route('booking.attach', [$booking])}}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title">Add Addon</h5>
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

                @if (count($addons)<=0)
                  <p>No addons available</p>
                @endif

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Addon</button>
            </div>
          </form>
        </div>
      </div>
    @endif --}}
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection