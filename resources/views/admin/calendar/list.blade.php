@extends('layouts.page')

@section('style')
  <style>
    .day{
      flex: 0 0 auto;
      width: 14%;
      border: 1px solid rgba(101, 109, 119, 0.16);
      padding: 10px;
      height: 150px;
    }
    .venue{
      border: 1px solid rgba(101, 109, 119, 0.16);
      height: 40px;
      display: flex;
      align-items: center;
      padding: 5px 10px;
      font-weight: bold;
      margin-bottom: 5px;
    }
    .dates{
      overflow-x: scroll;
    }
    .date{
      border: 1px solid rgba(101, 109, 119, 0.16);
      flex: 0 0 auto;
      width: 40px;
      height: 40px;
      margin-bottom: 5px;
      margin-right: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: white;
    }
    .date-head{
      color:black;
    }
    .booked {
      background: green;
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
            <h3 class="card-title">Calendar </h3>
          </div>
          <div class="col-sm-4 text-right">
            <form class="d-flex">
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

        <div class="card-body">
          <div class="flex flex-col">
            <div class="row">

              <div class="col-2">

                <div class="venue">
                  Venue
                </div>

                @foreach ($bookings as $key => $item)
                  <div class="venue text-truncate">
                    @php
                      $name = explode("|", $key)[0];
                      $fid = explode("|", $key)[1] ?? null;
                      $q = app('request')->query();
                      $q['facility'] = $fid;
                      $qs = http_build_query($q);
                    @endphp
                    <a href="?{{$qs}}">
                      {{ explode("|", $key)[0] }}
                    </a>
                  </div>
                @endforeach
               
              </div>
              <div class="col-10 dates pb-2">

                <div class="d-flex">
                  @for ($i=1; $i<=$days; $i++)
                    <div class="date date-head">{{$i}}</div>
                  @endfor
                </div>

                @foreach ($bookings as $key => $item)
                  <div class="d-flex">
                    @for ($i=1; $i<=$days; $i++)
                      @if($item->keys()->contains($i))
                        <div class="date booked">
                          {{$item[$i]->count()}}
                        </div>
                      @else
                        <div class="date"></div>
                      @endif
                    @endfor
                  </div>
                @endforeach

                

              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
