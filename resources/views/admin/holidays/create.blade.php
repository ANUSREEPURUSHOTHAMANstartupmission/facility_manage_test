@extends('layouts.page')

@section('page')
    <x-page-header heading="Holidays" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-8">

        <x-form-card action="{{route('admin.holidays.store')}}" back="admin.holidays.index">
        
          <div class="row">
            
            <div class="col-sm-6">
              <x-input-field label="Date" type="date" name="date" placeholder="Enter Date"></x-input-field>
            </div>

            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name"></x-input-field>
            </div>
            
        </x-form-card>

      </div>

    </div>
@endsection