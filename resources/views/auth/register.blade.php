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
                            <h3 class="my-4">Registration form</h3>
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
                  <form method="POST" action="{{ route('register') }}" class="form-validate">
                    @csrf
                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="reg_name" class="label-material">Name</label>
                            <input class="form-control" id="reg_name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="reg_email" class="label-material">Email</label>
                            <input class="form-control" id="reg_email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="input-material">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        {{-- Phone --}}
                        <div class="mb-3">
                            <label for="reg_phone" class="label-material">Phone</label>
                            <input class="form-control" id="reg_phone" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        {{-- Address --}}
                        <div class="mb-3">
                            <label for="reg_address" class="label-material">Address</label>
                            <input class="form-control" id="reg_address" type="text" name="address" :value="old('address')" required autofocus autocomplete="address">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="reg_password" class="label-material">Password</label>
                            <input class="form-control" id="reg_password" type="password" name="password"
                            required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label for="reg_con_password" class="label-material">Confirm Password</label>
                            <input class="form-control" id="reg_con_password" type="password" name="password_confirmation" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        {{-- Remember me --}}
                        <div class="mb-3">
                            <button class="btn btn-info w-100">{{ __('Register') }}</button>
                        </div>

                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </form>
                  <small>Already have an account? </small>
                  <a href="{{ route('login') }}" class="signup text-info">Log In</a>
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
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
