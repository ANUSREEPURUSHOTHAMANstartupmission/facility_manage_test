@extends('layouts.page')

@section('page')
    <x-page-header heading="Facilities" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-8">

        <x-form-card action="{{route('admin.facilities.store')}}" back="admin.facilities.index">
        
          <div class="row">

            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name"></x-input-field>
            </div>

            <div class="col-sm-3 pt-4">
              <x-checkbox type="switch" name="is_addon" value="true" label="Addon"></x-checkbox>
            </div>

            <div class="col-sm-3">
              <x-input-field label="Quantity" type="number" name="qty" placeholder="Enter Quantity" value="1"></x-input-field>
            </div>

            <div class="col-sm-3">
              <x-input-field label="Lead Time (Hours)" type="number" name="lead_time" placeholder="Enter Lead Time" value="4"></x-input-field>
            </div>

            <div class="col-sm-12">
              <x-textarea label="Description" type="text" name="description" placeholder="Description" required  ></x-textarea>
            </div>

            <div class="col-sm-12 mb-3">
              <x-textarea label="Content" type="text" name="brief" placeholder="Content" required ></x-textarea>
            </div>
            
            <div class="col-sm-4">
              <x-select-field label="Status" name="status">
                <x-select-option name="status" value="active" ></x-select-option>
                <x-select-option name="status" value="inactive" ></x-select-option>
              </x-select-field>
            </div>
            <div class="col-sm-4">
              <x-select-field label="Type" name="type">
                <x-select-option name="type" value="room" ></x-select-option>
                <x-select-option name="type" value="visit" ></x-select-option>
              </x-select-field>
            </div>
            <div class="col-sm-4">
              <x-select-field label="Location" name="location_id">
                @foreach ($locations as $location)
                  <x-select-option name="location_id" value="{{$location->id}}" label="{{$location->name}}"></x-select-option>
                @endforeach
              </x-select-field>
            </div>

            <div class="col-sm-12">
              <div class="form-label">Visit Availability</div>
              <div class="d-flex justify-content-between">
                <x-checkbox type="switch" name="availability[]" value="0" label="Sunday" ></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="1" label="Monday" ></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="2" label="Tuesday" ></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="3" label="Wednesday" ></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="4" label="Thursday" ></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="5" label="Friday" ></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="6" label="Saturday" ></x-checkbox>
              </div>
            </div>

          </div>

        </x-form-card>

      </div>

    </div>
@endsection

@section('script')

<script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
  CKEDITOR.replace( 'brief' );
</script>

@endsection