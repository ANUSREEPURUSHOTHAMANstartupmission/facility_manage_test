@extends('layouts.page')

@section('page')
    <x-page-header heading="Locations" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-sm-8">

        <x-form-card action="{{route('admin.locations.update', ['location' => $location->id])}}" back="admin.locations.index">
          @method('PUT')
          <div class="row">
            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name" value="{{$location->name}}"></x-input-field>
            </div>
            <!-- <div class="col-sm-6">
              <x-input-field label="District" type="text" name="district" placeholder="Enter District" value="{{$location->district}}"></x-input-field>
            </div> -->
            <div class="col-sm-6">
              <label for="district" class="pb-2">Enter District</label>
              <select name="district" id="district" class="form-control" required>
                  <option value="">Select District</option>
                  @foreach ($districts as $district)
                      <option value="{{ $district }}" {{ old('district', $location->district ?? '') == $district ? 'selected' : '' }}>
                          {{ $district }}
                      </option>
                  @endforeach
              </select>
            </div>
            <div class="col-sm-12">
              <x-textarea label="Map Embed Code" type="text" name="map" placeholder="Enter Map Embed code" value="{{$location->map}}"></x-textarea>
            </div>

            <div class="col-sm-12">
              <div class="form-label">Visit Availability</div>
              <div class="d-flex justify-content-between">
                <x-checkbox type="switch" name="availability[]" value="0" label="Sunday" checked="{{ in_array(0, $location->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="1" label="Monday" checked="{{ in_array(1, $location->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="2" label="Tuesday" checked="{{ in_array(2, $location->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="3" label="Wednesday" checked="{{ in_array(3, $location->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="4" label="Thursday" checked="{{ in_array(4, $location->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="5" label="Friday" checked="{{ in_array(5, $location->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="6" label="Saturday" checked="{{ in_array(6, $location->availability ?? [])?'true':'false' }}"></x-checkbox>
              </div>
            </div>

          </div>

        </x-form-card>

      </div>

    </div>
@endsection