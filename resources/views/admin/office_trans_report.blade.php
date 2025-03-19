<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>DEV POS - Office Transaction Report</title>
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
            <h2 class="h5 no-margin-bottom">Reports / Office Transaction Report</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('office.trans.report') }}" method="POST" id="office_trans_form">
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
                                        <label for="type" class="form-label">Transaction Type</label>
                                        <div>
                                            <input type="radio" id="expense" class="custom-radio" name="type" value="Expense" checked>
                                            <label for="expense" class="mr-3">Expense</label>

                                            <input type="radio" id="income" class="custom-radio" name="type" value="Income">
                                            <label for="income" class="mr-3">Income</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3" id="expense_div">
                                        <label class="form-label">Transaction Category</label>
                                        <select class="form-control form-control-sm form-select" name="exp_type" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($categories as $category)
                                                @if ($category->catType == 'Expense')
                                                    <option value="{{ $category->catName }}">
                                                        {{ $category->catName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3" id="income_div">
                                        <label class="form-label">Transaction Category</label>
                                        <select class="form-control form-control-sm form-select" name="exp_type" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($categories as $category)
                                                @if ($category->catType == 'Income')
                                                    <option value="{{ $category->catName }}">
                                                        {{ $category->catName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-4 my-2">
                                        <button type="submit" class="btn btn-primary mt-md-3 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($transactions->isNotEmpty())
                            <div class="block table-responsive">
                                <h5 class="text-center">Office Transactions From: {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} &nbsp;- To: {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</h5>
                                <table class="table table-hover" id="office_trans_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Trx No</th>
                                            <th scope="col">Transaction Category</th>
                                            <th scope="col">Transaction Type</th>
                                            <th scope="col">Account</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M, Y') }}</td>
                                                <td>{{$transaction->transactionNO}}</td>
                                                <td>{{$transaction->exp_type}}</td>
                                                <td>{{$transaction->type}}</td>
                                                <td>{{$transaction->account_name}}</td>
                                                <td>{{$transaction->amt_paid}}</td>
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

    <!-- Form Date Validation & Expense/Income Div -->
    <script>
        $(document).ready(function () {
            // Attach a submit event to the form
            $('#office_trans_form').on('submit', function (e) {
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

            // Initially hide the Income category, show the Expense category, and set the name attribute
            $('#income_div').addClass('d-none');
            $('#expense_div').removeClass('d-none');
            $('#income_div select').removeAttr('name');
            $('#expense_div select').attr('name', 'exp_type');

            // Listen for changes in the radio button selection
            $('input[name="type"]').change(function () {
                if ($(this).val() === 'Expense') {
                    $('#income_div').addClass('d-none');
                    $('#expense_div').removeClass('d-none');

                    // Update name attributes
                    $('#income_div select').removeAttr('name');
                    $('#expense_div select').attr('name', 'exp_type');
                } else if ($(this).val() === 'Income') {
                    $('#expense_div').addClass('d-none');
                    $('#income_div').removeClass('d-none');

                    // Update name attributes
                    $('#expense_div select').removeAttr('name');
                    $('#income_div select').attr('name', 'exp_type');
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
                $("#office_trans_table tbody tr").each(function () {
                    totalAmt += parseFloat($(this).find("td").eq(6).text()) || 0;
                });

                // Update the footer with the calculated totals
                let $tfoot = $("#office_trans_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalAmt.toFixed(2));
            }

            // Call the function on page load
            updateFooterTotals();
        });
    </script>
  </body>
</html>
