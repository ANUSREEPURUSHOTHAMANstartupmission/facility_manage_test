@perms($permissions)
    @if($type=="dropdown")
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                {{$slot}}
            </span>
            <span class="nav-link-title">
                {{$label}}
            </span>
            </a>
            <div class="dropdown-menu">
            {{$dropdown}}
            </div>
        </li>
        @elseif($type=="item")
        <a class="dropdown-item" href="{{$link}}" >
            {{$label}}
        </a>
        @else
        <li class="nav-item">
            <a class="nav-link" href="{{$link}}" >
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    {{$slot}}
                </span>
                <span class="nav-link-title">
                    {{$label}}
                </span>
            </a>
        </li>
    @endif
@endperms