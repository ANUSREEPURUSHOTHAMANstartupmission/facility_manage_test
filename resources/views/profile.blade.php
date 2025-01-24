@extends('layouts.page')

@section('page')
    <x-page-header heading="Profile" subhead="Edit"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-12 col-sm-8">

        <x-form-card action="{{route('profile.store')}}" back="profile.index">
          <div class="row" x-data="{category:'{{$user->category}}'}">

            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name" value="{{$user->name}}"></x-input-field>
            </div>
            <div class="col-sm-6">
              <x-input-field label="Phone" type="text" name="phone" placeholder="Enter Phone Number" value="{{$user->phone}}"></x-input-field>
            </div>
         
            <div class="col-sm-6">
              <x-input-field label="Organisation" type="text" name="organisation" placeholder="Enter Organisation Name" value="{{$user->organisation}}"></x-input-field>
            </div>

            <div class="col-sm-6">
              <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" x-model="category" class="form-control">
                  <x-select-option name="category" value="incubated" label="Incubated Startups" selected="{{$user->category}}"></x-select-option>
                  <x-select-option name="category" value="startup" label="DIPP Approved/ Unique ID Startup" selected="{{$user->category}}"></x-select-option>
                  <x-select-option name="category" value="associates" label="Associated Communities/ Industry Body" selected="{{$user->category}}"></x-select-option>
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <template x-if="category=='incubated' || category=='startup'">
                <x-input-field label="Unique ID" type="text" name="uid" placeholder="Enter Your Unique ID" value="{{$user->uid}}"></x-input-field>
              </template>
            </div>

          </div>

        </x-form-card>

      </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection