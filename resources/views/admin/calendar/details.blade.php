@extends('layouts.page')

@section('style')
  <style>
    .day_head{
      flex: 0 0 auto;
      width: 14%;
      border: 1px solid rgba(101, 109, 119, 0.16);
      padding: 10px;
      background: #ccc;
      font-weight: bold;
    }
    .day{
      flex: 0 0 auto;
      width: 14%;
      border: 1px solid rgba(101, 109, 119, 0.16);
      padding: 10px;
      height: 150px;
      overflow-y: scroll;
    }
    .time{
      font-weight: bold;
      font-size: 12px;
    }
    .booking{
      border: 10px;
      padding: 5px;
      display: block;
      background: #ccc3;
      border-radius: 5px;
      margin-bottom: 2px;
    }
  </style>
@endsection

@section('page')
  <x-page-header heading="Booking" subhead="Create"></x-page-header>
  <div class="row row-deck row-cards justify-content-center align-items-start">
    <div class="col-sm-12">
      <div class="card">

        <div class="card-header">
          <div class="col-sm-8">
            <h3 class="card-title">Calendar - {{$facility->name}}</h3>
          </div>
          <div class="col-sm-4 text-right">
            <form class="d-flex">
              <input type="hidden" name="facility" value="{{ app('request')->input('facility'); }}">
              <select name="month" class="form-select">
                <option {{ $month == "Jan" ? 'selected' : '' }}>Jan</option>
                <option {{ $month == "Feb" ? 'selected' : '' }}>Feb</option>
                <option {{ $month == "Mar" ? 'selected' : '' }}>Mar</option>
                <option {{ $month == "Apr" ? 'selected' : '' }}>Apr</option>
                <option {{ $month == "May" ? 'selected' : '' }}>May</option>
                <option {{ $month == "Jun" ? 'selected' : '' }}>Jun</option>
                <option {{ $month == "Jul" ? 'selected' : '' }}>Jul</option>
                <option {{ $month == "Aug" ? 'selected' : '' }}>Aug</option>
                <option {{ $month == "Sep" ? 'selected' : '' }}>Sep</option>
                <option {{ $month == "Oct" ? 'selected' : '' }}>Oct</option>
                <option {{ $month == "Nov" ? 'selected' : '' }}>Nov</option>
                <option {{ $month == "Dec" ? 'selected' : '' }}>Dec</option>
              </select>
              <input type="number" name="year" class="form-control" value="{{ $year ?? date('Y'); }}">
              <button type="submit" class="btn btn-secondary">View</button>
            </form>
          </div>
        </div>


        {{-- <pre>{{$bookings->keys()->contains($facility->name."|".$facility->id)}}</pre>
        <pre>{{$bookings[$facility->name."|".$facility->id]}}</pre> --}}

        <div class="card-body">
          <div class="flex flex-col">
            <div class="row">

              @foreach (array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat') as $item)
                <div class="day_head">{{$item}}</div>
              @endforeach

              @for ($i=0; $i<$empty; $i++)
                <div class="day"></div>
              @endfor

              @for ($i=1; $i<=$days; $i++)
                <div class="day">
                  <strong>{{$i}}</strong>

                  @if( $bookings->keys()->contains($facility->name."|".$facility->id) && $bookings[$facility->name."|".$facility->id]->keys()->contains($i))
                    @foreach ($bookings[$facility->name."|".$facility->id][$i] as $item)
                      @php
                        $class = $item->status=="pending"? 'bg-red':'';
                        $class .= $item->status=="requested"? 'bg-azure':'';
                        $class .= $item->status=="approved"? 'bg-orange':'';
                        $class .= $item->status=="confirmed"? 'bg-green':'';
                      @endphp
                      <a href="{{route('admin.bookings.show',[$item->id])}}" class="booking">
                        <span class="time">{{Carbon::parse($item->start)->format('g:i a')}}</span> - 
                        <span class="time">{{Carbon::parse($item->end)->format('g:i a')}}</span>
                        @foreach ($item->facilities as $fitem)
                          <span class="badge {{$class}}">{{$fitem->name}}</span>                            
                        @endforeach
                      </a>
                    @endforeach
                  @endif

                </div>
              @endfor

            </div>  

          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
