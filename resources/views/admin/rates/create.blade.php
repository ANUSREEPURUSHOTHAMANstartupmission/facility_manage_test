@extends('layouts.page')

@section('page')
    <x-page-header heading="Facility: {{$facility->name}}" subhead="Rate"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-6">

        <x-form-card action="{{route('admin.rates.store')}}" link="{{route('admin.facilities.edit', [$facility])}}">
        
          <div class="row">
            
            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name"></x-input-field>
            </div>
            
            <div class="col-sm-6">
              <x-input-field label="Rate" type="number" name="rate" placeholder="Enter Rate"></x-input-field>
            </div>

            <div class="col-sm-6">
              <x-input-field label="Duration" type="number" name="hours" placeholder="Enter Duration"></x-input-field>
            </div>

            <input type="hidden" name="facility_id" value="{{$facility->id}}">

          </div>
        </x-form-card>

      </div>

    </div>
@endsection