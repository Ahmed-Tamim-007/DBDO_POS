<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>Admin - Sales Report</title>
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
            <h2 class="h5 no-margin-bottom">Reports / Sales Reports</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('search.sales.reports') }}" method="POST" id="sales_invoice_form">
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
                                        <button type="submit" class="btn btn-primary mt-lg-4 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($sale_details->isNotEmpty())
                            <div class="block table-responsive text-center">
                                <h5 class="text-center">Sales From: {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} &nbsp;- To: {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</h5>
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
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    <!-- View Sales Modal -->
    @if ($sale_details->isNotEmpty())
        @foreach ($sale_details as $sale_detail)
            <div class="modal fade" id="viewSalesModal{{$sale_detail->id}}" tabindex="-1" role="dialog" aria-labelledby="viewSalesLabel{{$sale_detail->id}}" aria-hidden="true">
                <div class="modal-dialog printModal" role="document" id="printable{{$sale_detail->id}}">
                    <div class="modal-content">
                        <div class="modal-body p-5">
                            <div id="p_top" class="text-center">
                                <h5 id="p_head" style="font-size: 25px; font-weight: 400;">SAFI2 SUPER SHOP</h5>
                                <p id="p_address" style="font-size: 13px;">Taleb Ali Mosjid Road,Nijumbag,Sarulia,Demra,Dhaka -1361</p>
                                <hr style="border: 1px solid black; margin: 0px;">
                                <p id="p_vat" class="m-0">VAT Reg:</p>
                                <hr style="border: 1px solid black; margin: 0px;">
                            </div>
                            <div id="p_info" class="my-1" style="font-size: 13px;">
                                <p class="m-0" style="line-height: 1.1;">
                                    ServedBy: {{$sale_detail->user}}
                                </p>
                                <p class="m-0" style="line-height: 1.1;">
                                    Date: {{ \Carbon\Carbon::parse($sale_detail->created_at)->format('d M, Y h:i A') }}
                                </p>
                                <p class="m-0" style="line-height: 1.1;">
                                    Customer Name: {{ $sale_detail->customer_name ?? 'N/A' }}
                                </p>
                            </div>
                            <h5 id="p_invoice" class="text-center" style="font-size: 18px; font-weight: 400;">Invoive: {{$sale_detail->invoiceNo}}</h5>
                            <table class="table" id="viewSalesTable{{$sale_detail->id}}" border="0">
                                <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                                    <tr>
                                        <td>Product</td>
                                        <td>U.Price</td>
                                        <td>Qty</td>
                                        <td>Total(&#2547;)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales->where('sales_ID', $sale_detail->id) as $sale)
                                        <tr>
                                            <td>{{$sale->product_name}}</td>
                                            <td>{{$sale->price}}</td>
                                            <td>{{$sale->so_qty}}</td>
                                            <td>{{$sale->total}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bottom_border" style="border-bottom: 2px solid black;">
                                        <td colspan="2"><span class="total_item">0</span> Items</td>
                                        <td><span class="total_qty">0</span></td>
                                        <td><span class="total_price">0</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Discount</td>
                                        <td>{{$sale_detail->cashDiscount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Round:</td>
                                        <td>{{$sale_detail->cashRound}}</td>
                                    </tr>
                                    <tr class="bottom_border" style="border-bottom: 2px solid black;">
                                        <td colspan="3">Net Amount (&#2547;)</td>
                                        <td>{{$sale_detail->cashTotal}}</td>
                                    </tr>
                                    <tr class="dash_border" style="border-bottom:1px dashed black;">
                                        <td colspan="3">Payment Type</td>
                                        <td>Amount</td>
                                    </tr>
                                    @if ($sale_detail->cashAmount > 0)
                                        <tr>
                                            <td colspan="3">Cash</td>
                                            <td>{{$sale_detail->cashAmount}}</td>
                                        </tr>
                                    @endif
                                    @if ($sale_detail->cardAmount > 0)
                                        <tr>
                                            <td colspan="3">Card</td>
                                            <td>{{$sale_detail->cardAmount}}</td>
                                        </tr>
                                    @endif
                                    @if ($sale_detail->mobileAmount > 0)
                                        <tr>
                                            <td colspan="3">Mobile</td>
                                            <td>{{$sale_detail->mobileAmount}}</td>
                                        </tr>
                                    @endif

                                    <tr class="bottom_border" style="border-bottom: 2px solid black;" class="mt-1">
                                        <td colspan="3">Total Paid:</td>
                                        <td>{{$sale_detail->cashAmount + $sale_detail->cardAmount + $sale_detail->mobileAmount}}</td>
                                    </tr>
                                    <tr class="mt-2">
                                        <td colspan="3">Paid Amount:</td>
                                        <td>{{$sale_detail->cashPaid}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Due Amount:</td>
                                        <td>{{$sale_detail->cashDue}}</td>
                                    </tr>
                                    <tr class="dash_border" style="border-bottom: 1px dashed black;">
                                        <td colspan="3">Change Amt:</td>
                                        <td>{{$sale_detail->cashChange}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="text-center" style="font-size: 13px; margin-top: 30px;">
                                <p class="m-0 font-weight-bold" style="line-height: 1.1;">Shop Mobile No:01703338080</p>
                                <p class="m-0" style="line-height: 1.1;">Email-safi2supershop@gmail.com</p>
                                <p class="m-0" style="line-height: 1.1;">Web-www.safi2-supershop.com</p>
                                <p class="m-0" style="line-height: 1.1;">www.facebook.com/safi2supershop</p>
                                <p class="m-0" style="line-height: 1.1;">Software Developed By: www.dbdo.com</p>
                            </div>
                        </div>
                        <div id="modal_footer{{$sale_detail->id}}" class="modal-footer">
                            <button type="button" class="btn btn-secondary print_close_btn" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary print_btn" id="print_btn{{$sale_detail->id}}">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- JavaScript files-->
    @include('admin.dash_script')

    <script>
        $(document).ready(function () {
            // Attach a submit event to the form
            $('#sales_invoice_form').on('submit', function (e) {
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
    <!-- JS for Showing View Sales modal -->
    <script>
        $(document).ready(function() {
            // When the total_quantity td is clicked
            $('.view-sales-modal').on('click', function() {
                var sale_detail_Id = $(this).attr('id').replace('sale-detail', ''); // Get the product ID from the element's ID
                var modalId = '#viewSalesModal' + sale_detail_Id; // Build the modal ID

                // Trigger the modal to show
                $(modalId).modal('show');


                var tableId = '#viewSalesTable' + sale_detail_Id;
                // Function to update the totals
                function updateTotals() {
                    let totalItems = 0;
                    let totalQty = 0;
                    let totalPrice = 0;

                    // Iterate through each row in the tbody
                    $(tableId + " tbody tr").each(function () {
                        totalItems++; // Increment the total items count
                        let qty = parseFloat($(this).find("td:nth-child(3)").text()) || 0; // Get the Qty (3rd column)
                        let price = parseFloat($(this).find("td:nth-child(4)").text()) || 0; // Get the Price (4th column)
                        totalQty += qty; // Add to total quantity
                        totalPrice += price; // Add to total price
                    });

                    // Update the spans in the tfoot
                    $(".total_item").text(totalItems);
                    $(".total_qty").text(totalQty.toFixed(2)); // Format to 2 decimal places if needed
                    $(".total_price").text(totalPrice.toFixed(2)); // Format to 2 decimal places
                }
                // Call the function on page load
                updateTotals();
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
