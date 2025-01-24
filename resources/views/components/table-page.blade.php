@extends('layouts.page')

@section('page')
    <x-page-header heading="{{$heading}}" subhead="{{$subheading}}"></x-page-header>
    <div class="row row-deck row-cards">
      <div class="col-12">
        
        {{$table}}
        
      </div>
    </div>
@endsection