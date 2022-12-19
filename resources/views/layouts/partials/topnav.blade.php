<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
    
        <ul class="navbar-nav navbar-right">
        
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ url('images/default-avatar.svg') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">{{ __('message.hi', ['name' => Auth::user()->name]) }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              @if(auth()->user()->isAdmin)
              <a href="{{ route('adminstaffcreate') }}" class="dropdown-item has-icon">
                <i class="fas fa-user-plus"></i> {{ __('message.navmenus.new_user') }}
              </a>
              @endif
              <div class="dropdown-divider"></div>
               <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('message.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                </form>

            </div>
          </li>
        </ul>
      </nav>