@extends('layouts.page')

@section('page')
    <x-page-header heading="Users" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-12 col-sm-8">

        <x-form-card action="{{route('admin.users.store')}}" back="admin.users.index">
        
          <div class="row">
            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="Email" type="email" name="email" placeholder="Enter Email Address"></x-input-field>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <x-input-field label="Phone" type="text" name="phone" placeholder="Enter Phone Number" required="false"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-select-field label="Status" name="status">
                <x-select-option name="status" value="active" ></x-select-option>
                <x-select-option name="status" value="inactive" ></x-select-option>
              </x-select-field>
            </div>
            <div class="col-sm-6">
              <x-select-field label="Role" name="role_id">
                @foreach ($roles as $role)
                  <x-select-option name="role_id" value="{{$role->id}}" label="{{$role->name}}"></x-select-option>
                @endforeach
              </x-select-field>
            </div>
            
          </div>

        </x-form-card>


      </div>
    </div>
@endsection