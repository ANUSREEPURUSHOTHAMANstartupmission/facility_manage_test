@extends('layouts.page')

@section('page')
    <x-page-header heading="Facility : {{$facility->name}}" subhead="Assign Users"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-6">

        <x-form-card action="{{route('admin.facilities.assign', [$facility])}}" link="{{route('admin.facilities.show', [$facility])}}" >
        
          <div class="row">
            <div class="col-sm-12">
              <x-search-select name="user" label="User" route="admin.users.search"></x-search-select>
            </div>
          </div>

        </x-form-card>


      </div>
    </div>
@endsection