<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Add Transactions</title>
    <style>
        .crnt_balance {
            font-size: 13px;
        }
    </style>
  </head>
  <body>
    <!-- Header -->
    @include('admin.dash_header')

    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      @include('admin.dash_sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">Transactions / Fund Transfer</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <h3>New Transfer</h3>
                            <form class="validate_form" action="{{url('add_fund_trans')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <label class="required-label">Account From</label>
                                        <select class="form-control form-select account-select" name="accountFrom" aria-label="Default select example" required data-balance-target="#accountFromBalance">
                                            <option value="" selected>Select One</option>

                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">
                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="accountFromBalance" class="mt-2 text-info crnt_balance">Balance: --</div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <label class="required-label">Account To</label>
                                        <select class="form-control form-select account-select" name="accountTo" aria-label="Default select example" required data-balance-target="#accountToBalance">
                                            <option value="" selected>Select One</option>

                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">
                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="accountToBalance" class="mt-2 text-info crnt_balance">Balance: --</div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <label class="required-label">Amount</label>
                                        <input type="text" class="form-control trans_amt" name="amount" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mt-1 mb-4">
                                        <label class="">Description</label>
                                        <textarea name="description" class="form-control" rows="1"></textarea>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <input type="reset" class="btn btn-warning mt-1 px-5" value="Reset">
                                        <input type="submit" class="btn btn-primary mt-1 px-5" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="block">
                            <h3>List of Fund Transfers</h3>
                            <table class="datatable table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL</th>
                                        <th scope="col">Account From</th>
                                        <th scope="col">Account To</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($fund_transfers as $fund_transfer)
                                        <tr>
                                            <th scope="row">{{ $count }}</th>
                                            <td>
                                                {{ $fund_transfer->account_from_name }}
                                                <br>
                                                {{ $fund_transfer->account_from_no }}
                                            </td>
                                            <td>
                                                {{ $fund_transfer->account_to_name }}
                                                <br>
                                                {{ $fund_transfer->account_to_no }}
                                            </td>
                                            <td>{{ $fund_transfer->amount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($fund_transfer->created_at)->format('d M, Y h:i A') }}</td>
                                            <td>{{ $fund_transfer->description }}</td>
                                            <td>{{ $fund_transfer->user }}</td>
                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    @include('admin.dash_script')

    <script>
        $(document).ready(function () {
            const accountsData = @json($accounts);

            let accountFromBalance = 0; // Variable to store the accountFrom balance

            // Parse the accountsData JSON to use in JavaScript
            const accounts = accountsData.reduce((acc, account) => {
                acc[account.id] = account; // Create a mapping of account ID to account data
                return acc;
            }, {});

            // Prevent non-numeric inputs for the amount
            $('.trans_amt').on('input', function () {
                this.value = this.value.replace(/[^0-9.]/g, ''); // Allow numbers and decimals
                if ((this.value.match(/\./g) || []).length > 1) {
                    this.value = this.value.replace(/\.+$/, ''); // Remove extra decimals
                }
            });

            // Handle account selection change
            $('.account-select').on('change', function () {
                const accountId = $(this).val(); // Get the selected account ID
                const balanceTarget = $(this).data('balance-target'); // Get the target element to display balance

                if (accountId && accounts[accountId]) {
                    // Fetch the balance from the accounts object
                    const balance = accounts[accountId].crnt_balance;

                    // Display the balance in the target element
                    $(balanceTarget).text('Balance: ' + balance);

                    // Update accountFromBalance if this is the From account
                    if (balanceTarget === '#accountFromBalance') {
                        accountFromBalance = parseFloat(balance);
                    }
                } else {
                    // Clear the balance display if no account is selected
                    $(balanceTarget).text('Balance: --');

                    // Reset the accountFromBalance if no account is selected
                    if (balanceTarget === '#accountFromBalance') {
                        accountFromBalance = 0;
                    }
                }

                // Disable the selected account in the other dropdown
                const otherSelect = $(this).hasClass('account-select') ? $('.account-select').not(this) : null;

                if (otherSelect) {
                    otherSelect.find('option').prop('disabled', false); // Enable all options first
                    if (accountId) {
                        otherSelect.find(`option[value="${accountId}"]`).prop('disabled', true); // Disable the selected account
                    }
                }
            });

            // Prevent form submission if amount exceeds accountFrom balance
            $('.validate_form').on('submit', function (e) {
                const amount = parseFloat($('.trans_amt').val()); // Get the entered amount

                // Check if the amount exceeds the accountFrom balance
                if (amount > accountFromBalance) {
                    e.preventDefault(); // Prevent form submission
                    alert('The entered amount exceeds the balance of the selected "Account From". Please adjust the amount.');
                }
            });

            // Reset event for the form
            $('.validate_form').on('reset', function () {
                // Reset all balance display fields to their default text
                $('#accountFromBalance').text('Balance: --');
                $('#accountToBalance').text('Balance: --');

                // Reset the accountFromBalance variable
                accountFromBalance = 0;

                // Enable all options in both dropdowns
                $('.account-select option').prop('disabled', false);
            });
        });
    </script>
