@extends('layouts.page')

@section('page')
    <x-page-header heading="Home" subhead="Dashboard"></x-page-header>
    <div class="row row-deck row-cards">
      @foreach ($facilities as $facility)
        {{$facility->name}}
        
        <a href="{{route('facility.view', [$facility])}}">View</a>
      @endforeach
    </div>
@endsection