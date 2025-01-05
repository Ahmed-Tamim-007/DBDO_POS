<header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="index.html">
            <img src="{{asset('images/shop-logo2.png')}}" width="150px" height="auto">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""></span>
        </button>

        <div class="collapse navbar-collapse innerpage_navbar shadow" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link text-dark" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item {{ Request::is('shop') ? 'active' : '' }}">
                    <a class="nav-link text-dark" href="{{ url('shop') }}">Shop</a>
                </li>
                <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
                    <a class="nav-link text-dark" href="{{ url('about') }}">About Us</a>
                </li>
                <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}">
                    <a class="nav-link text-dark" href="{{ url('contact') }}">Contact Us</a>
                </li>
                <li class="nav-item pl-3">
                    <form action="{{ route('products.search') }}" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control" placeholder="Search products..." value="{{ request('q') }}" required>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </form>
                </li>
            </ul>
            <div class="user_option">
                @if (Route::has('login'))
                    @auth
                    <!-- Dropdown for logged-in users -->
                    <div class="dropdown">
                        <a class="nav-link {{ Request::is('profile') || Request::is('myorders') ? 'active' : '' }} text-dark dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user" style="color: #019bee; font-size: 18px;" aria-hidden="true"></i>&nbsp; {{ Auth::user()->name }} <!-- Display the user's name -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                            @if (Auth::check() && Auth::user()->usertype === 'admin')
                                <a class="dropdown-item" href="{{ url('admin/dashboard') }}">Admin dashboard</a>
                            @else
                                <a class="dropdown-item" href="{{url('myorders')}}">My Orders</a>
                                <a class="dropdown-item" href="{{url('myreview')}}">Review</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <!-- Logout form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                    @if (Auth::check() && Auth::user()->usertype === 'user')
                        <a class="nav-link cart-link {{ Request::is('mycart') ? 'active' : '' }} text-dark" href="{{url('mycart')}}">
                            <i class="fa fa-shopping-bag" style="color: #019bee;" aria-hidden="true"></i>
                            <span style="font-size: 13px">[{{$count}}]</span>
                        </a>
                    @endif
                    @else
                    <!-- Login option for guests -->
                    <a href="{{url('/login')}}">
                        <i class="fa fa-user" style="color: #019bee; font-size: 18px;" aria-hidden="true"></i>
                        <span>Login</span>
                    </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>
</header>
{{-- Back to top button --}}
<a href="#" id="back-to-top" title="Back to Top" style="display: none;">&#9650;</a>
