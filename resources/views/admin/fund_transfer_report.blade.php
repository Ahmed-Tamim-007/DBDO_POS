<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>Admin - Fund Transfer Report</title>
    <style>
        .is-invalid {
            border: 1px solid red !important;
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
            <h2 class="h5 no-margin-bottom">Reports / Fund Transfer Report</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('fund.transfer.report') }}" method="POST" id="fund_transfer_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">From Date</label>
                                        <input type="date" class="form-control form-control-sm" name="from_date">
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">To Date</label>
                                        <input type="date" class="form-control form-control-sm" name="to_date">
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Account From</label>
                                        <select class="form-control form-control-sm form-select" name="accountFrom" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">
                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Account To</label>
                                        <select class="form-control form-control-sm form-select" name="accountTo" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">
                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">User</label>
                                        <select class="form-control form-control-sm form-select" name="user" aria-label="Default select example">
                                            <option value="" selected>Select One</option>
                                            <option value="Admin">Admin</option>

                                            @foreach ($users as $user)
                                                <option value="{{$user->name}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-4 my-2">
                                        <button type="submit" class="btn btn-primary px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($transfers->isNotEmpty())
                            <div class="block table-responsive">
                                <h5 class="text-center">Fund Transfers From: {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} &nbsp;- To: {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</h5>
                                <table class="table table-hover" id="fund_transfer_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Account From</th>
                                            <th scope="col">Account To</th>
                                            <th scope="col">Discription</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transfers as $transfer)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('d M, Y') }}</td>
                                                <td>{{$transfer->account_from_name}} {{$transfer->account_from_no}}</td>
                                                <td>{{$transfer->account_to_name}} {{$transfer->account_to_no}}</td>
                                                <td>{{$transfer->description}}</td>
                                                <td>{{$transfer->user}}</td>
                                                <td>{{$transfer->amount}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" colspan="6" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    <!-- JavaScript files-->
    @include('admin.dash_script')

    <!-- Form Date Validation -->
    <script>
        $(document).ready(function () {
            // Attach a submit event to the form
            $('#fund_transfer_form').on('submit', function (e) {
                // Get the values of the "From Date" and "To Date" fields
                const fromDateField = $('input[name="from_date"]');
                const toDateField = $('input[name="to_date"]');
                const fromDate = fromDateField.val();
                const toDate = toDateField.val();

                let isValid = true;

                // Reset previous styles and error messages
                fromDateField.removeClass('is-invalid');
                toDateField.removeClass('is-invalid');
                $('.error-message').remove();

                // Check if "From Date" is empty
                if (fromDate === "") {
                    isValid = false;
                    fromDateField.addClass('is-invalid');
                    fromDateField.after('<span class="error-message" style="color: red; font-size: 12px;">Please fill this field!</span>');
                }

                // Check if "To Date" is empty
                if (toDate === "") {
                    isValid = false;
                    toDateField.addClass('is-invalid');
                    toDateField.after('<span class="error-message" style="color: red; font-size: 12px;">Please fill this field!</span>');
                }

                // Prevent form submission if any field is invalid
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
    <!-- Updating Table Footer based on the table rows -->
    <script>
        $(document).ready(function () {
            function updateFooterTotals() {
                let totalAmt = 0;

                // Iterate through each row in the tbody
                $("#fund_transfer_table tbody tr").each(function () {
                    totalAmt += parseFloat($(this).find("td").eq(6).text()) || 0;
                });

                // Update the footer with the calculated totals
                let $tfoot = $("#fund_transfer_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalAmt.toFixed(2));
            }

            // Call the function on page load
            updateFooterTotals();
        });
    </script>
  </body>
</html>
