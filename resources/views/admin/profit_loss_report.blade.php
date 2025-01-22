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
                                <table class="table table-hover" id="profit_loss_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">Date</th>
                                            <th scope="col">Sales Price</th>
                                            <th scope="col">Buying Price</th>
                                            <th scope="col">Return Sale</th>
                                            <th scope="col">Return Buy</th>
                                            <th scope="col">Round</th>
                                            <th scope="col">Profit/Loss</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profitLossData as $data)
                                            <tr>
                                                <td>{{ $data['date'] }}</td>
                                                <td data-value="{{ $data['total_sales_amount'] }}">{{ number_format($data['total_sales_amount'], 2) }}</td>
                                                <td data-value="{{ $data['total_purchase_cost'] }}">{{ number_format($data['total_purchase_cost'], 2) }}</td>
                                                <td data-value="{{ $data['total_returns_amount'] }}">{{ number_format($data['total_returns_amount'], 2) }}</td>
                                                <td data-value="{{ $data['total_returns_cost'] }}">{{ number_format($data['total_returns_cost'], 2) }}</td>
                                                <td data-value="{{ $data['total_round_amount'] }}">{{ number_format($data['total_round_amount'], 2) }}</td>
                                                <td data-value="{{ $data['profit_or_loss'] }}">{{ number_format($data['profit_or_loss'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" class="text-right">Net Total:</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
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
    <!-- Updating Table Footer based on the table rows -->
    <script>
        $(document).ready(function () {
            function updateProfitLossFooterTotals() {
                let totalSales = 0;
                let totalPurchase = 0;
                let totalReturn = 0;
                let totalReturnBuy = 0;
                let totalRound = 0;
                let totalProfit = 0;

                // Iterate through each row in the tbody
                $("#profit_loss_table tbody tr").each(function () {
                    totalSales += parseFloat($(this).find("td").eq(1).data('value')) || 0;
                    totalPurchase += parseFloat($(this).find("td").eq(2).data('value')) || 0;
                    totalReturn += parseFloat($(this).find("td").eq(3).data('value')) || 0;
                    totalReturnBuy += parseFloat($(this).find("td").eq(4).data('value')) || 0;
                    totalRound += parseFloat($(this).find("td").eq(5).data('value')) || 0;
                    totalProfit += parseFloat($(this).find("td").eq(6).data('value')) || 0;
                });

                // Update the footer with the calculated totals
                let $tfoot = $("#profit_loss_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalSales.toFixed(2));
                $tfoot.find("th").eq(2).text(totalPurchase.toFixed(2));
                $tfoot.find("th").eq(3).text(totalReturn.toFixed(2));
                $tfoot.find("th").eq(4).text(totalReturnBuy.toFixed(2));
                $tfoot.find("th").eq(5).text(totalRound.toFixed(2));
                $tfoot.find("th").eq(6).text(totalProfit.toFixed(2));
            }

            // Call the function on page load
            updateProfitLossFooterTotals();
        });
    </script>
  </body>
</html>
