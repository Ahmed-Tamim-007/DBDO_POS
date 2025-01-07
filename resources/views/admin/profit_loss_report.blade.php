<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>Admin - Profit-Loss Report</title>
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
            <h2 class="h5 no-margin-bottom">Reports / Profit-Loss Report</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block w-75 mx-auto">
                            <form action="{{ route('search.profit.loss.reports') }}" method="POST" id="profit_loss_form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">From Date</label>
                                        <input type="date" class="form-control form-control-sm" name="from_date">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">To Date</label>
                                        <input type="date" class="form-control form-control-sm" name="to_date">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <button type="submit" class="btn btn-primary mt-lg-4 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($profitLossData->isNotEmpty())
                            <div class="block table-responsive">
                                <h5 class="text-center">Profit/Loss From: {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} &nbsp;- To: {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</h5>
                                <table class="table table-hover" id="stock_report_table" style="border-bottom: 1px solid #019bee;">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">Date</th>
                                            <th scope="col">Total Sales Amount</th>
                                            <th scope="col">Total Purchase Cost</th>
                                            <th scope="col">Total Returns Amount</th>
                                            <th scope="col">Profit/Loss</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profitLossData as $data)
                                            <tr>
                                                <td>{{ $data['date'] }}</td>
                                                <td>{{ number_format($data['total_sales_amount'], 2) }}</td>
                                                <td>{{ number_format($data['total_purchase_cost'], 2) }}</td>
                                                <td>{{ number_format($data['total_returns_amount'], 2) }}</td>
                                                <td>{{ number_format($data['profit_or_loss'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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
            $('#profit_loss_form').on('submit', function (e) {
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
    <!-- Updating Totals based on the table rows -->
    <script>
        $(document).ready(function () {
            function updateStockReportSummary() {
                let totalQuantity = 0;
                let totalItems = 0;
                let totalStockValue = 0;
                let estimatedSellingPrice = 0;

                // Iterate through each row in the tbody
                $('#stock_report_table tbody tr').each(function () {
                    const quantity = parseFloat($(this).find('td').eq(5).text().trim()) || 0;
                    const purchasePrice = parseFloat($(this).find('td').eq(6).text().trim()) || 0;
                    const sellingPrice = parseFloat($(this).find('td').eq(7).text().trim()) || 0;

                    totalQuantity += quantity;
                    totalStockValue += quantity * purchasePrice;
                    estimatedSellingPrice += quantity * sellingPrice;
                    totalItems++; // Count each row
                });

                // Update the spans
                $('#t_qty').text(totalQuantity.toFixed(2));
                $('#t_item').text(totalItems.toFixed(2));
                $('#stock_val').text(totalStockValue.toFixed(2));
                $('#est_price').text(estimatedSellingPrice.toFixed(2));
            }

            // Call the function to update the summary on page load
            updateStockReportSummary();
        });
    </script>
  </body>
</html>
