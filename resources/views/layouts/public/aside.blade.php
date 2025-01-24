<nav id="navbar" class="{{ Route::is('welcome')?'alter':'' }}">
  <div class="hamburger-menu d-lg-none"><span></span><span></span><span></span><span></span></div>
  <div class="container">
    <div class="row"> 
      <div class="logo"></div>
      <div class="menu">
        <div class="logo"></div>
        <ul>
          @include('layouts.public.menu')
        </ul>
      </div>
    </div>
  </div>
</nav>

<script src="/js/nav.js" defer="defer"></script>