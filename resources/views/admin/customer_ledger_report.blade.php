<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>DEV POS - Customer Ledger Report</title>
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
                <h2 class="h5 no-margin-bottom">Reports / Customer Ledger Report</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('customer.ledger.report') }}" method="POST" id="customer_ledger_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">From Date</label>
                                        <input type="date" class="form-control form-control-sm" name="from_date">
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">To Date</label>
                                        <input type="date" class="form-control form-control-sm" name="to_date">
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3 position-relative">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" name="customer" class="form-control form-control-sm customer_search" autocomplete="off" placeholder="Search Customer...">
                                        <input type="hidden" name="customerID" class="customerID">
                                        <div class="customer_search_list list-group"></div>
                                    </div>

                                    <div class="col-lg-3 col-md-4 mx-auto my-2">
                                        <button type="submit" class="btn btn-primary mt-md-3 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($transactions->isNotEmpty())
                            <div class="block table-responsive">
                                <h5 class="text-center">Transactions From: {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} &nbsp;- To: {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</h5>
                                <table class="table table-hover" id="customer_ledger_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">Date</th>
                                            <th scope="col">Invoice No</th>
                                            <th scope="col">Account</th>
                                            <th scope="col">Due Amount</th>
                                            <th scope="col">Paid Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $lastSaleId = null;
                                        @endphp
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($transaction->sale_date)->format('d M, Y') }}</td>
                                                <td>
                                                    @if($lastSaleId !== $transaction->sale_id)
                                                        {{ $transaction->invoiceNo }}
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->account_name }}</td>
                                                <td>
                                                    @if($lastSaleId !== $transaction->sale_id)
                                                        {{ $transaction->cashDue }}
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->amt_paid }}</td>
                                            </tr>
                                            @php
                                                $lastSaleId = $transaction->sale_id;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot class="text-primary">
                                        <tr>
                                            <th scope="col" colspan="3" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" colspan="3"></th>
                                            <th scope="col">Due Amount:</th>
                                            <th scope="col" id="table_due">0.00</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" colspan="3"></th>
                                            <th scope="col">Settle Amount:</th>
                                            <th scope="col">{{ number_format($settled, 2) }}</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" colspan="3"></th>
                                            <th scope="col">Actual Due Amount:</th>
                                            <th scope="col">{{ number_format($actualDue, 2) }}</th>
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
            $('#customer_ledger_form').on('submit', function (e) {
                // Get the values of the fields
                const fromDateField = $('input[name="from_date"]');
                const toDateField = $('input[name="to_date"]');
                const customerField = $('input[name="customer"]');

                const fromDate = fromDateField.val();
                const toDate = toDateField.val();
                const customer = customerField.val();

                let isValid = true;

                // Reset previous styles and error messages
                fromDateField.removeClass('is-invalid');
                toDateField.removeClass('is-invalid');
                customerField.removeClass('is-invalid');
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

                // Check if "Customer" is empty
                if (customer === "") {
                    isValid = false;
                    customerField.addClass('is-invalid');
                    customerField.after('<span class="error-message" style="color: red; font-size: 12px;">Please fill this field!</span>');
                }

                // Prevent form submission if any field is invalid
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
    <!-- JS For customer search -->
    <script>
        $(document).ready(function () {
            $('.customer_search').on('keyup', function () {
                let query = $(this).val();

                // Clear the phone and due if the input is empty
                if (!query) {
                    $('.customer_search_list').html('');
                    $('.customerID').val('');
                    return;
                }

                $.ajax({
                    url: "{{ route('search.sales.customers') }}",
                    type: "GET",
                    data: { query: query },
                    success: function (data) {
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(customer => {
                                html += `<a href="#" class="list-group-customer list-group-customer-action"
                                             data-id="${customer.id}">
                                             ${customer.name.trim()} (${customer.phone.trim()})
                                         </a>`;
                            });
                        } else {
                            html = '<a href="#" class="list-group-customer">No customers found</a>';
                        }

                        $('.customer_search_list').html(html);
                    },
                    error: function () {
                        $('.customer_search_list').html('<a href="#" class="list-group-customer">An error occurred</a>');
                    }
                });
            });

            // Event delegation for dynamically added elements
            $(document).on('click', '.customer_search_list .list-group-customer', function (e) {
                e.preventDefault();

                let selectedName = $(this).text().trim();
                let customerId = $(this).data('id');

                $('.customer_search').val(selectedName);
                $('.customerID').val(customerId);
                $('.customer_search_list').html(''); // Clear the suggestions list
            });

            // Listen for changes to the .customer_search field
            $('.customer_search').on('input', function () {
                if (!$(this).val().trim()) {
                    $('.customerID').val(''); // Clear hidden customer ID
                    $('.customer_search_list').html(''); // Clear suggestions
                }
            });
        });
    </script>
    <!-- Updating Table Footer based on the table rows -->
    <script>
        $(document).ready(function () {
            function updateFooterTotals() {
                let totalDue = 0;
                let totalPaid = 0;
                let allDue = 0;

                // Iterate through each row in the tbody
                $("#customer_ledger_table tbody tr").each(function () {
                    totalDue += parseFloat($(this).find("td").eq(3).text()) || 0;
                    totalPaid += parseFloat($(this).find("td").eq(4).text()) || 0;
                });

                // Update the footer with the calculated totals
                let $tfoot = $("#customer_ledger_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalDue.toFixed(2));
                $tfoot.find("th").eq(2).text(totalPaid.toFixed(2));

                allDue = (totalDue - totalPaid);
                $("#customer_ledger_table tfoot #table_due").text(allDue.toFixed(2));
            }

            // Call the function on page load
            updateFooterTotals();
        });
    </script>
  </body>
</html>
