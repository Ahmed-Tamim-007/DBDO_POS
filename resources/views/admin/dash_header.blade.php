<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
            <div class="search-inner d-flex align-items-center justify-content-center">
            <div class="close-btn">Close <i class="fa fa-close"></i></div>
            <form id="searchForm" action="#">
                <div class="form-group">
                <input type="search" name="search" placeholder="What are you searching for...">
                <button type="submit" class="submit">Search</button>
                </div>
            </form>
            </div>
        </div>
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Header-->
                <a href="{{url('/')}}" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase">
                        <strong class="text-primary">SAFI2</strong><strong>POS</strong>
                    </div>
                    <div class="brand-text brand-sm">
                        <strong class="text-primary">S</strong><strong>P</strong>
                    </div>
                </a>
                <!-- Sidebar Toggle Btn-->
                <button class="sidebar-toggle"><i class="fa fa-bars"></i></button>
            </div>
            <div class="right-menu list-inline no-margin-bottom d-flex align-items-center">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="btn btn-outline-primary btn-sm" style="border-radius: 50%">
                    <i class="fas fa-sun"></i>
                </button>

                <!-- User Avatar and Dropdown -->
                <div class="header_user dropdown d-flex align-items-center">
                    <div class="avatar">
                        @if(Auth::user()->image)
                            <img src="{{ asset('users/' . Auth::user()->image) }}" class="img-fluid rounded-circle">
                        @else
                            <p style="font-size: 24px; color: #28a745; text-align: center;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </p>
                        @endif
                    </div>
                    <div class="title dropdown-toggle d-flex align-items-center" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div>
                            <h1 class="h5 mb-0">{{Auth::user()->name}}</h1>
                            <p class="mb-0">{{Auth::user()->usertype}}</p>
                        </div>
                    </div>
                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item oth_links" href="#">Profile</a>
                        <a class="dropdown-item oth_links" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <form id="logout" method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">{{ __('Log Out') }} <i class="icon-logout"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
