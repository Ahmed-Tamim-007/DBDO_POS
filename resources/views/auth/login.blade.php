<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Giftos - Login Page</title>
    <style>
        .form-control:focus {
            background-color: transparent;
            border-color: #17a2b8;
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
                <div class="info d-flex align-items-center" style="background-color: #17a2b8;">
                    <div class="content pl-3">
                        <div class="logo">
                            <h1>Giftos</h1>
                            <h3 class="my-4">Log In form</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, ipsam velit. Unde esse maiores pariatur soluta velit dolores qui sunt!</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, ipsam velit. Unde esse maiores pariatur soluta velit dolores qui sunt!</p>
                    </div>
                </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form method="POST" action="{{ route('login') }}" class="form-validate">
                    @csrf
                        <div class="mb-3">
                            <label for="login-email" class="label-material">Email</label>
                            <input class="form-control" id="login-email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="input-material">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="label-material">Password</label>
                            <input class="form-control" id="login-password" type="password" name="password"
                            required autocomplete="current-password" class="input-material">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
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

                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </form>
                  <small>Do not have an account? </small>
                  <a href="{{url('/register')}}" class="signup text-info">Register</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p class="no-margin-bottom">2024 &copy; <a target="_blank" href="#">Giftos</a> | Made with <span class="text-primary">&#10084;</span> By JA Tamim | <a target="_blank" href="tamimjr007@gmail.com">Contact Me</a></p>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.dash_script')
  </body>
</html>


{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
