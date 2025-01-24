@extends('layouts.main')

@section('content')

<div class="flex-fill d-flex flex-column justify-content-center py-4 h-100" style="min-height: 100vh">
  <div class="container-tight py-6">
    <div class="text-center mb-4">
      <a href="."><img src={{asset("./img/logo.svg")}} height="100" alt=""></a>
    </div>
    <form class="card card-md" action="{{route('register')}}" method="post" autocomplete="off">
      @csrf
      <div class="card-body" x-data="{category:'incubated'}">
        <h2 class="card-title text-center mb-4">Register</h2>
        <x-input-field label="Name" type="text" name="name" placeholder="Enter Contact Person Name"></x-input-field>
        <x-input-field label="Phone" type="number" name="phone" placeholder="Enter Phone"></x-input-field>
        <x-input-field label="Email Address" type="email" name="email" placeholder="Enter email" value="{{$email}}"></x-input-field>
        <x-input-field label="Organisation" type="text" name="organisation" placeholder="Enter Organisation Name"></x-input-field>

        <div class="mb-3">
          <label for="category" class="form-label">Category</label>
          <select name="category" x-model="category" class="form-control">
            <x-select-option name="category" value="incubated" label="Incubated Startups" ></x-select-option>
            <x-select-option name="category" value="startup" label="DIPP Approved/ Unique ID Startup"></x-select-option>
            <x-select-option name="category" value="associates" label="Associated Communities/ Industry Body"></x-select-option>
          </select>
        </div>

        <template x-if="category=='incubated' || category=='startup'">
          <x-input-field label="Unique ID" type="text" name="uid" placeholder="Enter Your Unique ID"></x-input-field>
        </template>
        
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </div>
      </div>
    </form>
    <div class="text-center text-muted mt-3">
      Don't have account yet? <a href="{{route('login')}}" tabindex="-1">Sign in</a>
    </div>

  </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection