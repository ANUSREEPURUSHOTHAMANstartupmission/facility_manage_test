@extends('layouts.page')

@section('page')
    <x-page-header heading="Startups" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-8">

        <x-form-card action="{{route('admin.startups.update', ['startup' => $startup->id])}}" back="admin.startups.index">
          @method('PUT')
          <div class="row">
            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name" value="{{$startup->name}}"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="Website" type="url" name="website" placeholder="Enter Website" value="{{$startup->website}}"></x-input-field>
            </div>
            
            <div class="col-sm-6">
              <x-input-field label="DIPP" type="text" name="dipp" placeholder="Enter DIPP Number" value="{{$startup->dipp}}"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="State" type="text" name="state" placeholder="Enter State" value="{{$startup->state}}"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="KSUM Unique ID" type="text" name="uid" placeholder="Enter KSUM unique ID" required="false" value="{{$startup->uid}}"></x-input-field>
            </div>
            <input type="hidden" name="logo" id="logo" value="{{$startup->logo}}">
          </div>

        </x-form-card>

      </div>
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">

            <x-cropper name="crop" label="Logo" target="logo" width=400 height=225 value="{{$startup->logo}}"></x-cropper>
  
          </div>
        </div>
      </div>
    </div>
@endsection