<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{Config::get('app.name')}}</title>
    <!-- CSS files -->

    <link href={{ asset("/css/main.css") }} rel="stylesheet"/>
    <link href={{ asset("/css/navbar.css") }} rel="stylesheet"/>
    @yield('style')
  </head>
  <body>
    @include('layouts.public.aside')

    @yield('content')

    <footer>
      <div id="ksum-copy">
        <div class="container">
          <div class="d-flex justify-content-between">
            <div>Copyright &copy; {{date('Y')}} All Rights Reserved.</div>
            <div class="text-right">
              {{-- <a href="https://business.startupmission.in/disclaimer" target="_blank">Disclaimer</a><span class="mx-2">|</span>
              <a href="https://business.startupmission.in/privacy" target="_blank">Privacy Policy</a><span class="mx-2">|</span>
              <a href="https://business.startupmission.in/termsofuse" target="_blank">Terms of Use</a><span class="mx-2">|</span> --}}
              <span>Powered by </span><a href="https://startupmission.kerala.gov.in" target="_blank">Kerala Startup Mission &#xae;</a></div>
          </div>
        </div>
      </div>
    </footer>

    <script src={{ asset("/js/main.js") }}></script>
    @yield('script')
  </body>
</html>