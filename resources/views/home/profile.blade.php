<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - Profile</title>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header_2')
  </div>

  {{-- Profile section --}}
  <section>
    <div class="container my-4">
        <div class="p-5 sm:p-8 shadow sm:rounded-lg my-4">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-5 sm:p-8 shadow sm:rounded-lg my-4">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-5 sm:p-8 shadow sm:rounded-lg my-4">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
  </section>

  <!-- footer section -->
  @include('home.footer')

  <!-- Code JS Files -->
  @include('home.script')

</body>

</html>
