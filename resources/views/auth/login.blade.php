<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Login Page</title>
    <style>
        .form-control:focus {
            background-color: transparent;
            border-color: #17a2b8;
        }

        #logo_img {
            height: 100px;
            width: auto;
        }

        @media screen and (max-width: 450px) {
            #logo_img {
                height: 70px;
                width: auto;
            }
        }
    </style>
  </head>
  <body>
    <div class="login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center" style="background-color: white;">
                            <div class="logo mx-auto">
                                <img src="{{asset('admin_css/img/dev_pos-logo.png')}}" alt="N/A" class="mx-auto mb-3" id="logo_img">
                                <h3 class="my-2 text-primary">Log in to access POS dashboard</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <form method="POST" action="{{ route('login') }}" class="form-validate mx-auto">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="login-email" class="label-material text-light">Email</label>
                                        <input class="form-control text-light" id="login-email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="input-material">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="login-password" class="label-material text-light">Password</label>
                                        <input class="form-control text-light" id="login-password" type="password" name="password"
                                        required autocomplete="current-password" class="input-material">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-info w-100">{{ __('Log in') }}</button>
                                    </div>

                                    <div>
                                        @if (Route::has('password.request'))
                                            <a class="text-info mb-2" href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </form>
                                <div class="text-center">
                                    <small>Do not have an account? </small>
                                    <a href="{{url('/register')}}" class="signup text-info">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights text-center">
            <p class="no-margin-bottom">{{ \Carbon\Carbon::now()->year }} <span class="text-primary">&copy;</span> DEV POS | Made by <a target="_blank" href="https://www.devbangla.xyz">Developer Bangladesh IT</a></p>
        </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.dash_script')
  </body>
</html>
