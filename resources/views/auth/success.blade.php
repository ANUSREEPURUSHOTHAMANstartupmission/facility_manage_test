@extends('layouts.main')

@section('content')
<p>Registration Successfull. You will be redirected to 
  <a href="{{route('login')}}">Login Page</a>
</p>
<script>
  alert('Registration Successfull');
  window.location.href = "{{route('login')}}"
</script>
@endsection