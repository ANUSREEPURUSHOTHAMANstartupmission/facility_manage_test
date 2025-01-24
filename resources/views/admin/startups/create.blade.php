@extends('layouts.page')

@section('page')
    <x-page-header heading="Startups" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-8">

        <x-form-card action="{{route('admin.startups.store')}}" back="admin.startups.index">
        
          <div class="row">
            <h3 class="mb-3">Startup Details</h3>
            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="Website" type="url" name="website" placeholder="Enter Website"></x-input-field>
            </div>
            
            <div class="col-sm-6">
              <x-input-field label="DIPP" type="text" name="dipp" placeholder="Enter DIPP Number"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="State" type="text" name="state" placeholder="Enter State"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="KSUM Unique ID" type="text" name="uid" placeholder="Enter KSUM unique ID" required="false"></x-input-field>
            </div>

            <hr class="mb-3">
            
            <h3 class="mb-3">User Details</h3>

            <div class="col-sm-6">
              <x-input-field label="Founder Name" type="text" name="founder" placeholder="Enter User Name"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="Email" type="email" name="email" placeholder="Enter Email"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="Phone" type="text" name="phone" placeholder="Enter Phone Number" required="false"></x-input-field>
            </div>
            <div class="col-sm-6 pt-4">
              <x-checkbox name="notify" type="switch" value="notify" label="Notify User"></x-checkbox>
            </div>
            <input type="hidden" name="logo" id="logo">
          </div>

        </x-form-card>

      </div>
      
      
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">

            <x-cropper name="crop" label="Logo" target="logo" width=400 height=225 ></x-cropper>
  
          </div>
        </div>
      </div>

    </div>
@endsection