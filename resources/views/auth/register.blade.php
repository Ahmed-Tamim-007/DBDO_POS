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
                <div class="info d-flex align-items-center" style="background-color: white;">
                    <div class="logo mx-auto">
                        <img src="{{asset('admin_css/img/dev_pos-logo.png')}}" alt="N/A" class="mx-auto mb-3" id="logo_img">
                        <h3 class="my-2 text-primary">Please Create An Account</h3>
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
        <p class="no-margin-bottom">{{ \Carbon\Carbon::now()->year }} <span class="text-primary">&copy;</span> DEV POS | Made by <a target="_blank" href="https://www.devbangla.xyz">Developer Bangladesh IT</a></p>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.dash_script')
  </body>
</html>

