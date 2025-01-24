@extends('layouts.public.main')

@section('style')
    <link rel="stylesheet" href="{{asset('/css/facility.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

@endsection

@section('content')

<div class="header-section">
    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($images as $item)
                    <li class="splide__slide">
                        <img src="{{route('storage.file', ['images',$item])}}" alt="" class="img-fluid">
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
                <h1>{{$location->name}}</h1>

                @foreach ($facilities as $facility)
                    
                    <p class="text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="11" r="3"></circle>
                            <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
                        </svg>
                        {{$facility->name}}
                    </p>
                    <p class="text-muted">{{$facility->description}}</p>

                    <div class="content">
                        {!!$facility->brief!!}
                    </div>

                @endforeach

                @if($location->map)
                    <iframe src="{{$location->map}}" style="border:0;width:100%;height:300px" allowfullscreen="" loading="lazy"></iframe>
                @endif
                
            </div>
            <div class="col-sm-4 pt-sm-0 pt-5">

                <div class="booking">
                    <form action="{{route('visit.view', [$location])}}">
                        <div class="d-flex align-items-end flex-wrap">
                            
                            <div class="date-picker">
                                <div class="d-flex flex-column w-100">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" required placeholder="Pick Date"
                                        min="{{Carbon::now()->toDateString()}}"
                                        max="{{Carbon::now()->addMonth()->toDateString()}}"
                                        value="{{ app('request')->input('date')??Carbon::now()->addDay()->toDateString() }}">
                                </div>
                                <div class="d-flex flex-column w-50">
                                    <label for="qty">Number of Visitors</label>
                                    <input type="number" name="qty" id="qty" required step="5" max="60" min="5"
                                        value="{{ app('request')->input('qty')?? 10  }}">
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

                    @if(app('request')->input('date') && app('request')->input('qty'))
                        @if ($available)

                            <form action="{{route('visit.store', [$location, 'qty' => app('request')->input('qty'), 'date' => app('request')->input('date') ])}}" method="POST">
                                @csrf

                                <div class="pt-3">
                                    @foreach ($rates as $rate)
                                        <label class="form-selectgroup-item flex-fill">
                                            <input type="checkbox" name="facilities[]" value="{{$rate['id']}}" class="form-selectgroup-input">
                                            <div class="form-selectgroup-label d-flex align-items-center p-3 mb-2">
                                                <div class="me-3">
                                                  <span class="form-selectgroup-check"></span>
                                                </div>
                                                <div class="form-selectgroup-label-content d-flex align-items-center" style="text-align: left;">
                                                  <div>
                                                    <div class="font-weight-medium">{{$rate['name']}}</div>
                                                    <div class="text-small">Rs. {{$rate['rate']}}</div>
                                                  </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                               
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
                                Visit is not available on the selected date.
                            </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // window.start_date = "{{ app('request')->input('start') }}";
    // window.end_date = "{{ app('request')->input('end') }}";
</script>
    
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{asset('js/facility.js')}}"></script>
@endsection