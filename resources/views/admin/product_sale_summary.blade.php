<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>Admin - Product Sales Report</title>
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
            <h2 class="h5 no-margin-bottom">Reports / Product Sales Report</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('search.product.report') }}" method="POST" id="product_sales_form">
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
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Invoice No</label>
                                        <input type="text" class="form-control form-control-sm" name="invoice">
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Customer Name</label>
                                        <select class="form-control form-control-sm form-select" name="c_name" aria-label="Default select example">
                                            <option value="" selected>Select One</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Customer Type</label>
                                        <select class="form-control form-control-sm form-select" name="c_type" aria-label="Default select example">
                                            <option value="" selected>Select One</option>
                                            <option value="Basic">Basic</option>
                                            @foreach ($customer_types as $customer_type)
                                                <option value="{{$customer_type->type_name}}">{{$customer_type->type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Sold By</label>
                                        <select class="form-control form-control-sm form-select" name="user" aria-label="Default select example">
                                            <option value="" selected>Select One</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->name}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <input type="submit" class="btn btn-primary mt-lg-4 px-5" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="block table-responsive text-center">
                            <table class="table table-striped table-hover" id="sales_invoice_table">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL.</th>
                                        <th scope="col">Invoice No</th>
                                        <th scope="col">Sold By</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Discount Amount</th>
                                        <th scope="col">Sale Price</th>
                                        <th scope="col">Cash</th>
                                        <th scope="col">Card</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Due Amount</th>
                                        <th scope="col">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($sale_details->isNotEmpty())
                                        @foreach ($sale_details as $sale_detail)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td><strong>
                                                        {{$sale_detail->invoiceNo}}
                                                    </strong><br>
                                                    <span style="font-size: 11px;">
                                                        {{ \Carbon\Carbon::parse($sale_detail->created_at)->format('d M, Y h:i A') }}
                                                    </span>
                                                </td>
                                                <td>{{$sale_detail->user}}</td>
                                                <td>{{ $sale_detail->customer_name ?? 'N/A' }} <br>
                                                    <span style="background-color: #019bee; color:white; border-radius: 3px; padding: 0px 5px; font-size: 10px;">{{ $sale_detail->customer_type }}</span>
                                                </td>
                                                <td>{{$sale_detail->cashDiscount}}</td>
                                                <td>{{$sale_detail->cashTotal}}</td>
                                                <td>{{$sale_detail->cashAmount}}</td>
                                                <td>{{$sale_detail->cardAmount}}</td>
                                                <td>{{$sale_detail->mobileAmount}}</td>
                                                <td>{{$sale_detail->cashDue ?? 0.00 }}</td>
                                                <td>
                                                    <a href="javascript:void(0);" id="sale-detail{{$sale_detail->id}}" class="view-sales-modal" data-id="{{$sale_detail->id}}" style="text-decoration: none;">
                                                        <button class="btn btn-outline-success btn-xs">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="text-primary">
                                        <th scope="col" colspan="4" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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

    <!-- JavaScript files-->
    @include('admin.dash_script')

    <!-- Form Date Validation -->
    <script>
        $(document).ready(function () {
            // Attach a submit event to the form
            $('#product_sales_form').on('submit', function (e) {
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
                let totalDiscount = 0;
                let totalSalePrice = 0;
                let totalCash = 0;
                let totalCard = 0;
                let totalMobile = 0;
                let totalDue = 0;

                // Iterate through each row in the tbody
                $("#sales_invoice_table tbody tr").each(function () {
                    totalDiscount += parseFloat($(this).find("td").eq(4).text()) || 0; // Discount Amount
                    totalSalePrice += parseFloat($(this).find("td").eq(5).text()) || 0; // Sale Price
                    totalCash += parseFloat($(this).find("td").eq(6).text()) || 0; // Cash
                    totalCard += parseFloat($(this).find("td").eq(7).text()) || 0; // Card
                    totalMobile += parseFloat($(this).find("td").eq(8).text()) || 0; // Mobile
                    totalDue += parseFloat($(this).find("td").eq(9).text()) || 0; // Due Amount
                });

                // Update the footer with the calculated totals
                let $tfoot = $("#sales_invoice_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalDiscount.toFixed(2)); // Update Discount Total
                $tfoot.find("th").eq(2).text(totalSalePrice.toFixed(2)); // Update Sale Price Total
                $tfoot.find("th").eq(3).text(totalCash.toFixed(2)); // Update Cash Total
                $tfoot.find("th").eq(4).text(totalCard.toFixed(2)); // Update Card Total
                $tfoot.find("th").eq(5).text(totalMobile.toFixed(2)); // Update Mobile Total
                $tfoot.find("th").eq(6).text(totalDue.toFixed(2)); // Update Due Total
            }

            // Call the function on page load
            updateFooterTotals();

            // Optionally, re-calculate totals if the table data changes dynamically
            $(document).on("change", "#sales_invoice_table tbody", function () {
                updateFooterTotals();
            });
        });
    </script>
  </body>
</html>
