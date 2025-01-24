<header class="navbar navbar-expand-md navbar-dark navbar-overlap d-print-none">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
      <a href=".">
        <img src={{ asset("/img/logo-white.svg") }} width="200" height="50" alt="KSUM" class="navbar-brand-image">
      </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
      {{-- <div class="nav-item dropdown d-none d-md-flex me-3">
        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
          <span class="badge bg-red"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
          <div class="card">
            <div class="card-body">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
            </div>
          </div>
        </div>
      </div> --}}
      @auth
        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm" >
              {{substr(Auth::user()->name, 0,1)}}
            </span>
            <div class="d-none d-xl-block ps-2">
              <div>{{Auth::user()->name}}</div>
              <div class="mt-1 small text-muted">{{Auth::user()->role->name}}</div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a href="{{route('profile.index')}}" class="dropdown-item">Profle</a>
            <a href="{{route('logout')}}" class="dropdown-item">Logout</a>
          </div>
        </div>
      @endauth
    </div>
    <div class="collapse navbar-collapse" id="navbar-menu">
      <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
        <ul class="navbar-nav">
  

          <x-nav-item label="Home" link="{{route('home')}}" permissions="home:view">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
          </x-nav-item>

          <x-nav-item label="Basic" type="dropdown" permissions="admin:user:view|admin:role:view">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
            <x-slot name="dropdown">

              <x-nav-item label="Users" link="{{route('admin.users.index')}}" type="item" permissions="admin:user:view"></x-nav-item>
              <x-nav-item label="Roles" link="{{route('admin.roles.index')}}" type="item" permissions="admin:role:view"></x-nav-item>
              
            </x-slot>
          </x-nav-item>

          <x-nav-item label="Holiday" link="{{route('admin.holidays.index')}}" permissions="admin:holiday:view">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M19.823 19.824a2 2 0 0 1 -1.823 1.176h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 1.175 -1.823m3.825 -.177h9a2 2 0 0 1 2 2v9"></path>
              <line x1="16" y1="3" x2="16" y2="7"></line>
              <line x1="8" y1="3" x2="8" y2="4"></line>
              <path d="M4 11h7m4 0h5"></path>
              <line x1="11" y1="15" x2="12" y2="15"></line>
              <line x1="12" y1="15" x2="12" y2="18"></line>
              <line x1="3" y1="3" x2="21" y2="21"></line>
            </svg>
          </x-nav-item>

          <x-nav-item label="Location" link="{{route('admin.locations.index')}}" permissions="admin:location:view">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <line x1="18" y1="6" x2="18" y2="6.01"></line>
              <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5"></path>
              <polyline points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15"></polyline>
              <line x1="9" y1="4" x2="9" y2="17"></line>
              <line x1="15" y1="15" x2="15" y2="20"></line>
            </svg>
          </x-nav-item>

          <x-nav-item label="Facility" link="{{route('admin.facilities.index')}}" permissions="admin:facility:view">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-bank" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <line x1="3" y1="21" x2="21" y2="21"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
              <polyline points="5 6 12 3 19 6"></polyline>
              <line x1="4" y1="10" x2="4" y2="21"></line>
              <line x1="20" y1="10" x2="20" y2="21"></line>
              <line x1="8" y1="14" x2="8" y2="17"></line>
              <line x1="12" y1="14" x2="12" y2="17"></line>
              <line x1="16" y1="14" x2="16" y2="17"></line>
           </svg>
          </x-nav-item>

          <x-nav-item label="Booking" link="{{route('admin.bookings.index')}}" permissions="admin:booking:view">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-color-swatch" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M19 3h-4a2 2 0 0 0 -2 2v12a4 4 0 0 0 8 0v-12a2 2 0 0 0 -2 -2"></path>
              <path d="M13 7.35l-2 -2a2 2 0 0 0 -2.828 0l-2.828 2.828a2 2 0 0 0 0 2.828l9 9"></path>
              <path d="M7.3 13h-2.3a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h12"></path>
              <line x1="17" y1="17" x2="17" y2="17.01"></line>
            </svg>
          </x-nav-item>

          <x-nav-item label="Calendar" link="{{route('admin.calendar.view')}}" permissions="admin:calendar:view">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <rect x="4" y="5" width="16" height="16" rx="2"></rect>
              <line x1="16" y1="3" x2="16" y2="7"></line>
              <line x1="8" y1="3" x2="8" y2="7"></line>
              <line x1="4" y1="11" x2="20" y2="11"></line>
              <rect x="8" y="15" width="2" height="2"></rect>
            </svg>
          </x-nav-item>

        </ul>

      </div>
    </div>
  </div>
</header>