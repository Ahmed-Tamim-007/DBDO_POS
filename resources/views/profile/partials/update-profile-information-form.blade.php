<section>
    <div class="heading_container text-center">
        <h2>{{ __('Profile Information') }}</h2>

        <p class="mt-1 mb-5 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" class="form-control" value="{{$user->name}}" required autofocus autocomplete="name" >
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{$user->email}}" required autocomplete="username" >
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="btn btn-sm btn-warning">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" type="text" class="form-control" value="{{$user->phone}}" required autofocus autocomplete="phone" >
            </div>

            <div class="col-md-6 mb-3">
                <label for="address">Address</label>
                <input id="address" name="address" type="text" class="form-control" value="{{$user->address}}" required autofocus autocomplete="address" >
            </div>
        </div>

        <div class="flex items-center gap-4 text-center">
            <input type="submit" class="btn btn-primary my-2" value="Save Changes">

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
