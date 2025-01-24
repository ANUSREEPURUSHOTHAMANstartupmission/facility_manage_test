@extends('layouts.page')

@section('style')
  
@endsection

@section('page')
    <x-page-header heading="Facilities" subhead="Create"></x-page-header>
    <div class="row row-cards justify-content-center">
      <div class="col-sm-6">

        <x-form-card action="{{route('admin.facilities.update', ['facility' => $facility->id])}}" back="admin.facilities.index">
          @method('PUT')
          <div class="row">
            <div class="col-sm-6">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name" value="{{$facility->name}}"></x-input-field>
            </div>
            
            <div class="col-sm-3 pt-4">
              <x-checkbox type="switch" name="is_addon" value="true" label="Addon" checked="{{$facility->is_addon?'true':'false'}}"></x-checkbox>
            </div>

            <div class="col-sm-3">
              <x-input-field label="Quantity" type="number" name="qty" placeholder="Enter Quantity" value="{{$facility->qty}}"></x-input-field>
            </div>

            <div class="col-sm-3">
              <x-input-field label="Lead Time (Hours)" type="number" name="lead_time" placeholder="Enter Lead Time" value="{{$facility->lead_time}}"></x-input-field>
            </div>

            <div class="col-sm-12">
              <x-textarea label="Description" type="text" name="description" placeholder="Description" value="{{$facility->description}}"></x-textarea>
            </div>

            <div class="col-sm-12 mb-3">
              <x-textarea label="Content" type="text" name="brief" placeholder="Content" value="{!!$facility->brief!!}"></x-textarea>
            </div>
            
            <div class="col-sm-6">
              <x-select-field label="Status" name="status">
                <x-select-option name="status" value="active" selected="{{$facility->status}}"></x-select-option>
                <x-select-option name="status" value="inactive" selected="{{$facility->status}}"></x-select-option>
              </x-select-field>
            </div>
            <div class="col-sm-4">
              <x-select-field label="Type" name="type">
                <x-select-option name="type" value="room" selected="{{$facility->type}}"></x-select-option>
                <x-select-option name="type" value="visit" selected="{{$facility->type}}"></x-select-option>
              </x-select-field>
            </div>
            <div class="col-sm-6">
              <x-select-field label="Location" name="location_id">
                @foreach ($locations as $location)
                  <x-select-option name="location_id" value="{{$location->id}}" label="{{$location->name}}" selected="{{$facility->location_id}}"></x-select-option>
                @endforeach
              </x-select-field>
            </div>
            <div class="col-sm-12">
              <div class="form-label">Facility Availability</div>
              <div class="d-flex justify-content-between flex-wrap">
                <x-checkbox type="switch" name="availability[]" value="0" label="Sunday" checked="{{ in_array(0, $facility->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="1" label="Monday" checked="{{ in_array(1, $facility->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="2" label="Tuesday" checked="{{ in_array(2, $facility->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="3" label="Wednesday" checked="{{ in_array(3, $facility->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="4" label="Thursday" checked="{{ in_array(4, $facility->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="5" label="Friday" checked="{{ in_array(5, $facility->availability ?? [])?'true':'false' }}"></x-checkbox>
                <x-checkbox type="switch" name="availability[]" value="6" label="Saturday" checked="{{ in_array(6, $facility->availability ?? [])?'true':'false' }}"></x-checkbox>
              </div>
            </div>
          </div>

        </x-form-card>

      </div>

      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-6">
                <h3>Rates</h3>
              </div>
              <div class="col-6">
                <div class="d-flex">
                  <a href="{{route('admin.rates.create', [$facility])}}" class="btn btn-success ms-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <line x1="12" y1="5" x2="12" y2="19"></line>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Create
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table card-table table-vcenter">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Rate</th>
                  <th>Hours</th>
                  <th class="w-1"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($facility->rates as $rate)
                  <tr>
                    <td>{{$rate->name}}</td>
                    <td>{{$rate->rate}}</td>
                    <td>{{$rate->hours}}</td>
                    <td class="w-1">
                      <a class="btn btn-link p-0 text-primary" href="{{route('admin.rates.edit', [$facility, $rate])}}" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                            <line x1="16" y1="5" x2="19" y2="8"></line>
                        </svg>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-sm-4">
        <div class="card">
          <form class="card-body" action="{{ route('admin.facility.image', [$facility]) }}" method="POST">
            @csrf
            <input type="hidden" name="image" id="image" >
            <x-cropper name="crop" label="Image" target="image" width=500 height=500></x-cropper>
            <button type="submit" class="btn btn-primary mt-2">Upload</button>
          </form>
        </div>
      </div>

      @foreach ($facility->images as $image) 
        <div class="col-sm-3">
          <form class="card" action="{{ route('admin.image.delete', [$image]) }}" method='POST'>
            @csrf
            @method('DELETE')
            <div class="card-img-top img-responsive" style="background-image: url({{ route('storage.file', ['images', $image->image]) }})"></div>
            <button class="btn btn-danger btn-sm">Delete</button>
          </form>
          </form>
        </div>
      @endforeach

    </div>
@endsection

@section('script')

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<script>
  CKEDITOR.replace( 'brief' );
</script>

@endsection