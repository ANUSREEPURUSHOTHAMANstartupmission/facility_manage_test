@extends('layouts.page')

@section('style')
    <link rel="stylesheet" href="{{asset('/css/facility.css')}}">
@endsection

@section('page')
  <x-page-header heading="Booking" subhead="Create"></x-page-header>
  <div class="row row-deck row-cards justify-content-center align-items-start">
    <div class="col-sm-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Choose Facility</h3>
        </div>
        <div class="card-body">
          <div class="flex flex-col">
            @foreach ($facilities as $item)
                @php
                  $q = $query;
                  $q['facility'] = $item->id;
                  $qs = http_build_query($q);
                @endphp
                <a href="?{{$qs}}" class="form-selectgroup-item flex-fill">
                  <input type="checkbox" name="facility" value="" {{$item->id == app('request')->input('facility')?'checked':''}} class="form-selectgroup-input">
                  <div class="form-selectgroup-label d-flex align-items-center p-3 mb-2">
                      <div class="me-3">
                        <span class="form-selectgroup-check"></span>
                      </div>
                      <div class="form-selectgroup-label-content d-flex align-items-center" style="text-align: left;">
                        <div>
                          <div class="font-weight-medium">{{$item->name}}</div>
                          <div class="text-small">{{$item->location->name}}</div>
                        </div>
                      </div>
                  </div>
                </a>

            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 d-flex flex-column">

      @if(app('request')->input('facility'))
        <form class="card">
          <div class="card-header">
            <h3 class="card-title">Choose Time</h3>
          </div>
          <div class="card-body">
            <input type="hidden" name="facility" value="{{$facility->id}}">
            <div class="date-picker">
              <div class="d-flex flex-column w-100">
                  <label for="date" class="text-dark mb-2">Date</label>
                  <input type="date" name="date" id="date" required placeholder="Pick Date"
                      min="{{Carbon::now()->subMonths(2)->toDateString()}}"
                      max="{{Carbon::now()->addMonths(2)->toDateString()}}"
                      value="{{ app('request')->input('date')??Carbon::now()->addDay()->toDateString() }}">
              </div>
              <div class="d-flex flex-column w-50">
                  <label for="time" class="text-dark mb-2">Time</label>
                  <input type="time" name="time" id="time" required placeholder="Pick Time" step="60"
                      value="{{ app('request')->input('time')??Carbon::now()->roundMinute()->toTimeString()  }}">
              </div>
            </div>

            <div class="rate-picker">
              <label for="date" class="text-dark mb-2">Select Duration</label>
              <div class="form-selectgroup form-selectgroup-boxes d-flex">

                  @foreach ($facility->rates()->orderBy('hours')->get() as $rate_item)
                      <label class="form-selectgroup-item flex-fill">
                          <input type="radio" name="duration" required value="{{$rate_item->id}}" {{ $rate_item->id == app('request')->input('duration') ? 'checked' : '' }} class="form-selectgroup-input">
                          <div class="form-selectgroup-label d-flex align-items-center py-2 px-3">
                              <div class="me-3">
                                  <span class="form-selectgroup-check"></span>
                              </div>
                              <div class="form-selectgroup-label-content d-flex align-items-center">
                                  <div>
                                      <div class="font-weight-medium">{{$rate_item->name}}</div>
                                      <div class="text-muted">{{$rate_item->hours}} Hours</div>
                                  </div>
                              </div>
                          </div>
                      </label>
                  @endforeach

              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button class="chk-btn" type="submit">
                <svg version="1.1" id="L5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                    <circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
                        <animateTransform 
                        attributeName="transform" 
                        dur="1s" 
                        type="translate" 
                        values="0 15 ; 0 -15; 0 15" 
                        repeatCount="indefinite" 
                        begin="0.1"/>
                    </circle>
                    <circle fill="#fff" stroke="none" cx="30" cy="50" r="6">
                        <animateTransform 
                        attributeName="transform" 
                        dur="1s" 
                        type="translate" 
                        values="0 10 ; 0 -10; 0 10" 
                        repeatCount="indefinite" 
                        begin="0.2"/>
                    </circle>
                    <circle fill="#fff" stroke="none" cx="54" cy="50" r="6">
                        <animateTransform 
                        attributeName="transform" 
                        dur="1s" 
                        type="translate" 
                        values="0 5 ; 0 -5; 0 5" 
                        repeatCount="indefinite" 
                        begin="0.3"/>
                    </circle>
                </svg>
                <span>Check Availablity</span>
              </button>
            </div>

          </div>
        </form>

      @endif

      @if(app('request')->input('date') && app('request')->input('time') && $rate_data)
        @if ($available)
          <div class="card mt-3">
            <div class="card-body">

                <div class="facility-price mt-0">
                  <small>{{$facility->name}} x {{$hours}} Hours = </small>
                  <span>Rs.</span>{{$rate}}
                </div>

            </div>
          </div>

          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title">Booking For</h3>
            </div>
            <div class="card-body">
              <form>

                <input type="hidden" name="facility" value="{{$facility->id}}">
                <input type="hidden" name="time" id="time" value="{{ app('request')->input('time') }}">
                <input type="hidden" name="date" id="date" value="{{ app('request')->input('date') }}">
                <input type="hidden" name="duration" id="duration" value="{{ app('request')->input('duration') }}">

                <x-input-field label="Email" type="email" name="email" placeholder="Enter Email Address" value="{{ app('request')->input('email') }}"></x-input-field>

                <div class="d-flex justify-content-end">
                  <button class="chk-btn mt-0" type="submit">
                    <span>Get User</span>
                  </button>
                </div>

              </form>

              @if(app('request')->input('email'))
                <form action="{{route('admin.bookings.store', $query)}}" method="POST">
                  @csrf

                  @if ($user)
                    <dl class="row mt-3">
                      <dt class="col-5">Name:</dt>
                      <dd class="col-7">{{$user->name}}</dd>
                      <dt class="col-5">Email:</dt>
                      <dd class="col-7">{{$user->email}}</dd>
                      <dt class="col-5">Phone:</dt>
                      <dd class="col-7">{{$user->phone}}</dd>
                      <dt class="col-5">Organisation:</dt>
                      <dd class="col-7">{{$user->organisation}}</dd>
                      <dt class="col-5">Category:</dt>
                      <dd class="col-7">{{$user->category}}</dd>
                      @if ($user->uid)
                        <dt class="col-5">Unique ID:</dt>
                        <dd class="col-7">{{$user->uid}}</dd>
                      @endif
                    </dl>
                  @else
                    <div x-data="{category:'incubated'}">
                      <x-input-field label="Name" type="text" name="name" placeholder="Enter Name" ></x-input-field>
                      <x-input-field label="Phone" type="number" name="phone" placeholder="Enter Phone" ></x-input-field>
                      <x-input-field label="Organisation" type="text" name="organisation" placeholder="Enter Organisation" ></x-input-field>
                      
                      <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" x-model="category" class="form-control">
                          <x-select-option name="category" value="incubated" label="Incubated Startups" ></x-select-option>
                          <x-select-option name="category" value="startup" label="DIPP Approved/ Unique ID Startup"></x-select-option>
                          <x-select-option name="category" value="associates" label="Associated Communities/ Industry Body"></x-select-option>
                        </select>
                      </div>

                      <template x-if="category=='incubated' || category=='startup'">
                        <x-input-field label="Unique ID" type="text" name="uid" placeholder="Enter Your Unique ID"></x-input-field>
                      </template>
                    </div>
                  @endif

                  <x-textarea name="purpose" label="Purpose" placeholder="Enter Purpose of booking" value=""></x-textarea>
                  <x-input-field label="Number of Participants" type="number" name="participants" placeholder="Enter number of participants" value=""></x-input-field>                  

                  <button class="book-btn ms-auto" type="submit">
                    <span>Continue</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <line x1="13" y1="18" x2="19" y2="12"></line>
                        <line x1="13" y1="6" x2="19" y2="12"></line>
                    </svg>
                  </button>

                </form>
              @endif

            </div>
          </div>

        @else
          <div class="alert alert-danger mt-4" role="alert">
              This facility is not available in the selected period.
          </div>
        @endif
      @endif

    </div>
  </div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection
