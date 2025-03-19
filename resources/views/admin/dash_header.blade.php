<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Header-->
                <a href="{{url('/')}}" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase">
                        <img src="{{ asset('admin_css/img/DEV_POS-logo.png') }}" height="35px" width="auto">
                    </div>
                    <div class="brand-text brand-sm">
                        <img src="{{ asset('admin_css/img/DEV_POS-icon.png') }}" height="35px" width="auto">
                        <strong style="color: #019bee;">D</strong><strong style="color: #007bbf;">P</strong>
                    </div>
                </a>
                <!-- Sidebar Toggle Btn-->
                <button class="sidebar-toggle"><i class="fa fa-bars"></i></button>
            </div>

            <div class="time-greeting text-center d-none d-md-flex">
                <span id="greeting">Good Morning,</span> {{ Auth::user()->name }}!
                <i class="fas fa-clock"></i>
                <span class="current-time" id="currentTime"></span>
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

<style>
    .time-greeting {
        font-size: 16px;
        color: white;
        background: linear-gradient(135deg, #019bee, #007bbf);
        padding: 5px 15px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .time-greeting i {
        color: #ffffff;
    }

    @media (max-width: 450px) {
        .time-greeting {
            display: none;
        }
    }
</style>

<script>
    function updateClock() {
        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes().toString().padStart(2, "0");
        let greeting = hours < 12 ? "Good Morning," : hours < 18 ? "Good Afternoon," : "Good Evening,";

        document.getElementById("greeting").textContent = greeting;
        document.getElementById("currentTime").innerHTML = now.toLocaleTimeString();
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
