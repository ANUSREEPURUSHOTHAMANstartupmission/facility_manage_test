<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{Config::get('app.name')}}</title>
    <!-- CSS files -->
     
    <link href={{ asset("/css/tabler.css") }} rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('style')
  </head>
  <body class="antialiased">
    <x-flash-message></x-flash-message>

    @yield('content')

    <script src={{ asset("/js/tabler.js") }}></script>
    
    @yield('script')

  </body>
</html>