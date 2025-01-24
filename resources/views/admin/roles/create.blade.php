@extends('layouts.page')

@section('page')
    <x-page-header heading="Roles" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-12">

        <x-form-card action="{{route('admin.roles.store')}}" back="admin.roles.index">
        
          <div class="row">
            <div class="col-sm-4">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name"></x-input-field>
            </div>
            <div class="col-sm-4">
              <x-input-field label="Description" type="text" name="description" placeholder="Enter Description"></x-input-field>
            </div>
            <div class="col-sm-4">
              <x-input-field label="Type" type="text" name="type" placeholder="Enter Type" required="false"></x-input-field>
            </div>
          </div>

          <div class="row">
            @foreach($perms as $item)
              <div class="col-md-4">
                <x-checkbox type="switch" name="permissions[]" value="{{$item->id}}" label="{{$item->name}}"></x-checkbox>
              </div>
            @endforeach
            
          </div>

        </x-form-card>


      </div>
    </div>
@endsection