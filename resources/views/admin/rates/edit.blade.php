@extends('layouts.page')

@section('page')
    <x-page-header heading="Facility: {{$facility->name}}" subhead="Rate"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-6">

        <x-form-card action="{{route('admin.rates.update', ['rate' => $rate->id])}}"  link="{{route('admin.facilities.edit', [$facility])}}">
          @method('PUT')
          <div class="row">
            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name" value="{{$rate->name}}"></x-input-field>
            </div>

            <div class="col-sm-6">
              <x-input-field label="Rate" type="number" name="rate" placeholder="Enter Rate" value="{{$rate->rate}}"></x-input-field>
            </div>

            <div class="col-sm-6">
              <x-input-field label="Duration" type="number" name="hours" placeholder="Enter Duration" value="{{$rate->hours}}"></x-input-field>
            </div>
          </div>

        </x-form-card>

      </div>

    </div>
@endsection