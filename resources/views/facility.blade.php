@extends('layouts.public.main')

@section('style')
    <link rel="stylesheet" href="{{asset('/css/facility.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
<style>
    .day_head {
        flex: 0 0 auto;
        width: 14%;
        border: 1px solid rgba(101, 109, 119, 0.16);
        padding: 5px; /* Reduced padding */
        background: #ccc;
        font-weight: bold;
        font-size: 12px; /* Smaller font size */
        text-align: center;
        font-weight: bold;

    }
    .day {
        flex: 0 0 auto;
        width: 14%;
        border: 1px solid rgba(101, 109, 119, 0.16);
        padding: 0; 
        height: 50px;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        overflow-y: scroll;
        text-align: center;
        font-size: 10px;
        font-weight:normal;
    }
    .bg-secondary {
        background-color: rgb(151, 154, 158) !important; 
    }
    .bg-light {
        background-color: rgb(222, 224, 226) !important; 
    }
    .bg-red {
        background-color:rgba(234, 16, 35, 0.61) !important;
    }
    .bg-azure {
        background-color: #d1ecf1 !important;
    }
    .bg-orange {
        background-color: #fff3cd !important;
    }
    .bg-green {
        background-color: #d4edda !important;
    }
    .time {
        font-size: 10px; 
        display: block;
        margin: 2px 0;    }
    .booking {
        border: 1px solid #ccc; 
        padding: 2px; 
        display: block;
        background: rgba(204, 204, 204, 0.3); 
        border-radius: 3px; 
        margin-bottom: 2px;
        font-size: 10px; 
        overflow: hidden;
        white-space: nowrap; 
        text-overflow: ellipsis;
    }
</style>

@endsection

@section('content')

<div class="header-section">
    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($facility->images as $item)
                    <li class="splide__slide">
                        <img src="{{route('storage.file', ['images',$item->image])}}" alt="" class="img-fluid">
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="facility-section">
    <div class="container mt-sm-5">
        <div class="row">
            <div class="col-sm-8">
                <h3>{{$facility->name}}</h3>
                <p class="text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="11" r="3"></circle>
                        <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
                    </svg>
                    {{$facility->location->name}}
                </p>
                <p class="text-muted">{{$facility->description}}</p>

                <div class="content">
                    {!!$facility->brief!!}
                </div>

                @if($facility->location->map)
                    <iframe src="{{$facility->location->map}}" style="border:0;width:100%;height:300px" allowfullscreen="" loading="lazy"></iframe>
                @endif
                
            </div>
            <div class="col-sm-4 pt-sm-0 pt-5">

                <div class="booking">
                    <form action="{{route('facility.view', [$facility])}}">
                        <div class="d-flex align-items-end flex-wrap">
                            {{-- <div class="datetimes d-flex">
                                <div class="d-flex flex-column">
                                    <label for="start">Start Date</label>
                                    <input type="text" name="start" id="start" required placeholder="Pick Date" value="{{ app('request')->input('start') }}">
                                </div>
                                <div class="d-flex flex-column ms-3">
                                    <label for="start">End Date</label>
                                    <input type="text" name="end" id="end" required placeholder="Pick Date" value="{{ app('request')->input('end') }}">
                                </div>
                            </div> --}}
                            
                            <div class="date-picker">
                                <div class="d-flex flex-column w-50">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" required placeholder="Pick Date"
                                        min="{{Carbon::now()->toDateString()}}"
                                        max="{{Carbon::now()->addMonth()->toDateString()}}"
                                        value="{{ app('request')->input('date')??Carbon::now()->addDay()->toDateString() }}">
                                </div>
                                <div class="d-flex flex-column w-50">
                                    <label for="time">Time</label>
                                    {{-- <input type="time" name="time" id="time" required placeholder="Pick Time" step="60"
                                        value="{{ app('request')->input('time')??Carbon::now()->roundMinute()->toTimeString()  }}"> --}}
                                    <select name="time" id="time" required placeholder="Pick Time" >
                                        <option value="" selected disabled>--select--</option>
                                        <option value="09:00" {{ app('request')->input('time') == "09:00" ? 'selected' : '' }} >Forenoon</option>
                                        {{-- <option value="10:00" {{ app('request')->input('time') == "10:00" ? 'selected' : '' }} >10:00 AM</option>
                                        <option value="11:00" {{ app('request')->input('time') == "11:00" ? 'selected' : '' }} >11:00 AM</option>
                                        <option value="12:00" {{ app('request')->input('time') == "12:00" ? 'selected' : '' }} >12:00 PM</option> --}}
                                        <option value="13:30" {{ app('request')->input('time') == "13:30" ? 'selected' : '' }} >Afternoon</option>
                                        {{-- <option value="14:00" {{ app('request')->input('time') == "14:00" ? 'selected' : '' }} >02:00 PM</option>
                                        <option value="15:00" {{ app('request')->input('time') == "15:00" ? 'selected' : '' }} >03:00 PM</option>
                                        <option value="16:00" {{ app('request')->input('time') == "16:00" ? 'selected' : '' }} >04:00 PM</option> --}}
                                    </select>

                                </div>
                            </div>

                            <div class="rate-picker">
                                <label for="date">Select Duration</label>
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
                    </form>

                    @if(app('request')->input('date') && app('request')->input('time'))
                        @if ($available)
                            
                            <div class="facility-price">
                                <small>{{$facility->name}} x {{$hours}} Hours = </small>
                                <span>Rs.</span>{{$rate}}
                            </div>

                            <form action="{{route('facility.store', [$facility, 'time' => app('request')->input('time'), 'date' => app('request')->input('date'), 'duration' => app('request')->input('duration') ])}}" method="POST">
                                @csrf
                               
                                {{-- <input type="hidden" name="time" id="time" value="{{ app('request')->input('time') }}">
                                <input type="hidden" name="date" id="date" value="{{ app('request')->input('date') }}">
                                <input type="hidden" name="duration" id="duration" value="{{ app('request')->input('duration') }}">
                                 --}}
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
                        @else
                            <div class="alert alert-danger mt-4" role="alert">
                                This facility is not available in the selected period.
                            </div>
                        @endif
                    @endif
                </div>

<!-- calendar -->
                <div class=" mt-4">
                    <div class="row row-deck row-cards justify-content-center align-items-start">
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="flex flex-col">
                                        <div class="row">

                                            @foreach (array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat') as $item)
                                                <div class="day_head">{{$item}}</div>
                                            @endforeach

                                            @for ($i=0; $i<$empty; $i++)
                                                <div class="day align-middle text-center"></div>
                                            @endfor

                                            <!-- ##### -->
                                                @php
                                                    // Map month name to numeric value if $month is a string
                                                    if (!is_numeric($month)) {
                                                        $monthMap = [
                                                            "Jan" => 1, "Feb" => 2, "Mar" => 3, "Apr" => 4, 
                                                            "May" => 5, "Jun" => 6, "Jul" => 7, "Aug" => 8, 
                                                            "Sep" => 9, "Oct" => 10, "Nov" => 11, "Dec" => 12
                                                        ];
                                                        $month = $monthMap[$month] ?? 1; // Default to January if not found
                                                    }

                                                    $today = Carbon\Carbon::today(); // Get today's date
                                                @endphp

                                                @for ($i=1; $i<=$days; $i++)
                                                    @php
                                                        $availability = $facility->availability; 
                                                        $currentDate = Carbon\Carbon::create($year, $month, $i); 
                                                        $dayOfWeek = $currentDate->dayOfWeek;
                                                        $dayClass = '';

                                                        if (!in_array($dayOfWeek, $availability)) {
                                                            $dayClass = 'bg-red'; // Gray for unavailable days
                                                        } 

                                                        $isHoliday = $holidays->contains(function ($holiday) use ($currentDate) {
                                                            return $holiday->date === $currentDate->toDateString();
                                                        });

                                                        if ($isHoliday) {
                                                            $dayClass = 'bg-red'; // Red for holidays
                                                        }

                                                        if ($bookings->keys()->contains($facility->name."|".$facility->id) && 
                                                            $bookings[$facility->name."|".$facility->id]->keys()->contains($i)) {
                                                            foreach ($bookings[$facility->name."|".$facility->id][$i] as $item) {
                                                                if ($item->status == "approved") {
                                                                    $dayClass = 'bg-red'; // Red for approved bookings
                                                                }
                                                                break; // Exit loop after assigning the first applicable class
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="day {{$dayClass}}">
                                                        <strong>{{$i}}</strong>
                                                    </div>
                                                @endfor




                                            <!-- ###### -->

                                        </div>  
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



<!-- calendar -->


            </div>
        </div>
    </div>
</div>



















<script>
    window.start_date = "{{ app('request')->input('start') }}";
    window.end_date = "{{ app('request')->input('end') }}";
</script>
    
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{asset('js/facility.js')}}"></script>
@endsection