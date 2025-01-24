@extends('layouts.main')

@section('style')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script type="text/javascript">
    var sih_auth_api_key = "eyJhbGciOiJIUzUxMiIsInppcCI6IkRFRiJ9.eNp8jj2OwjAQhe8ydSCJ4mDhihNss-WKYuxMiJGxLXssLULcfQeJbSnfz_f0HnBlDwZmq92qDo6UHQ6TRj2M46LWBTrAtkjhK5UbBpG1WZHF1w3tdsrJ14z3vUs3yTwymHE-jnpQ0zR3QL_5bSg9v4xWqYB5QG42yATJNJdGgsalVS6eKpgfqH4zb-ferz5idMTkNjjLAXKcysdaL7ci79K6qxhkUaiQHLJPUb6_qH_ZC-6xv7QrFjnfQUmBpPPNWLhleD7_AAAA__8.Ta5zIoPxI3TViffy4LD-nZWdzcmuTkZFYgTJQa8iS_EpqkeuQo-YsZDk68ZoCGLhKFOrIdB4w9BWR6Kco5rHbQ";
    var sih_auth_callback_uri = "http://localhost/silogin/callback";
  </script>

@endsection

@section('content')

<div class="flex-fill d-flex flex-column justify-content-center py-4 h-100" style="min-height: 100vh">
  <div class="container-tight py-6">
    <div class="text-center mb-4">
      <a href="."><img src={{asset("./img/logo.svg")}} height="100" alt=""></a>
    </div>
    <form class="card card-md" action="{{route('login')}}" method="post" autocomplete="off">
      @csrf
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Login to your account</h2>
        <x-input-field label="Email Address" type="email" name="email" placeholder="Enter email"></x-input-field>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Sign in</button>
        </div>
      </div>
    </form>
    <div class="text-center text-muted mt-3">
      Don't have account yet? <a href="{{route('register')}}" tabindex="-1">Sign up</a>
    </div>
    <div class="card card-md mt-3">
      <div class="card-body">
        <button class="oauth-login">Sign In with Startup India</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('script')

<script type="text/javascript" src="https://www.startupindia.gov.in/etc/designs/invest-india/investindialibs/js/siauthlogin.js"></script>
{{-- <script type="text/javascript" src="https://sih.qa.intelligrape.net/etc/designs/invest-india/investindialibs/js/siauthlogin.js"></script> --}}


@endsection
