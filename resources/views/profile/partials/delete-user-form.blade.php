<section class="space-y-6">
    <div class="heading_container text-center">
        <h2>{{ __('Delete Account') }}</h2>

        <p class="mt-1 mb-5 text-sm text-gray-600">
            {{ __("Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.") }}
        </p>
    </div>

    <div class="text-center">
        <button class="btn btn-danger my-2" id="deleteAccountButton">{{ __('Delete Account') }}</button>
    </div>

    <!-- Hidden form to submit the delete request -->
    <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm" style="display: none;">
        @csrf
        @method('delete')

        <input type="password" id="password" name="password" required placeholder="{{ __('Password') }}">

    </form>
</section>

<script>
    document.getElementById('deleteAccountButton').addEventListener('click', function() {
        Swal.fire({
            title: '{{ __('Are you sure?') }}',
            text: '{{ __("Once deleted, you will not be able to recover your account!") }}',
            icon: 'warning',
            input: 'password',
            inputPlaceholder: '{{ __("Enter your password") }}',
            showCancelButton: true,
            confirmButtonText: '{{ __("Delete Account") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            preConfirm: (password) => {
                if (!password) {
                    Swal.showValidationMessage('{{ __("Please enter your password") }}');
                } else {
                    // Populate the password into the hidden form input
                    document.getElementById('password').value = password;
                    // Submit the hidden form
                    document.getElementById('deleteAccountForm').submit();
                }
            }
        });
    });
</script>
