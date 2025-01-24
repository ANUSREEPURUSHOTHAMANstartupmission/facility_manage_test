<li><a class="nav-item" href="{{route('welcome')}}"> <span>Home</span></a></li>
@auth
  <div class="login-user">
    <a href="/home" data-bs-toggle="dropdown">
      <span class="avatar avatar-sm" >
        {{substr(Auth::user()->name, 0,1)}}
      </span>
      <div class="ps-2">
        <div>{{Auth::user()->name}}</div>
        <div class="small text-muted">
          {{Auth::user()->role->name}}
        </div>
      </div>
    </a>
  </div>
  <li>
    <a href="{{route('logout')}}" class="nav-item">
      <span>Logout</span>
    </a>
  </li>

@endauth
@guest
  <li class="login"><a class="nav-item" href="{{route('login')}}"> <span>Login</span></a></li>
@endguest
{{-- <li><a class="nav-item" href="#"> <span>Business for Startups</span></a></li> --}}