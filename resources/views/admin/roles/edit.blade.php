@extends('layouts.page')

@section('page')
    <x-page-header heading="Roles" subhead="Create"></x-page-header>
    <div class="row row-deck row-cards justify-content-center">
      <div class="col-12">

        <x-form-card action="{{route('admin.roles.update', ['role' => $role->id])}}" back="admin.roles.index">
          @method('PUT')
          <div class="row">
            <div class="col-sm-4">
              <x-input-field label="Name" type="text" name="name" placeholder="Enter Name" value="{{$role->name}}"></x-input-field>
            </div>
            <div class="col-sm-4">
              <x-input-field label="Description" type="text" name="description" placeholder="Enter Description" value="{{$role->description}}"></x-input-field>
            </div>
            <div class="col-sm-4">
              <x-input-field label="Type" type="text" name="type" placeholder="Enter Type" value="{{$role->type}}" required="false"></x-input-field>
            </div>
          </div>

          <div class="row">
            @foreach($perms as $item)
              <div class="col-md-4">
                <x-checkbox type="switch" name="permissions[]" value="{{$item->id}}" label="{{$item->name}}" checked="{{ in_array($item->id, $current)?'true':'false' }}"></x-checkbox>
              </div>
            @endforeach
          </div>

        </x-form-card>


      </div>
    </div>
@endsection