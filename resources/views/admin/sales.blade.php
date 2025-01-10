<!DOCTYPE html>
<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.dash_head')
    <title>Admin - Sales</title>
    <style>
        .td_1 {
            width: 80%;
        }

        .td_2 {
            width: 20%;
        }
        .table tr td {
            padding: 5px 7px;
        }
    </style>
  </head>
  <body>
    <!-- Header -->
    @include('admin.dash_header')

    <div class="d-flex align-items-stretch" id="sales_content">
        <!-- Sidebar Navigation-->
        @include('admin.dash_sidebar')
        <!-- Sidebar Navigation end-->
        <div class="page-content" style="width: 100% !important;">
            <section class="no-padding-top" style="padding-top: 2rem !important">
                <div class="container-fluid">
                    <div class="row" id="wrapper">
                        <div class="col-md-8">
                            <div class="block">
                                <form id="product_form">
                                    <div class="row mb-3" id="sales_search">
                                        <div class="col-lg-11 col-md-9 position-relative pr-md-0">
                                            <input type="text" id="product_search" name="product" class="form-control" autocomplete="off" placeholder="Search Product...">
                                            <div id="product_search_list" class="list-group"></div>
                                            <input type="hidden" name="batch_no" id="">
                                        </div>
                                        <div class="col-lg-1 col-md-3 pl-md-0">
                                            <button type="submit" class="btn btn-info w-100" style="border-radius: 0px;"><i class="icon-magnifying-glass-browser"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-5 position-relative pr-md-0">
                                        <input type="text" id="customer_search" name="customer" class="form-control" autocomplete="off" placeholder="Search Customer...">
                                        <input type="hidden" name="customerID" id="customerID">
                                        <div id="customer_search_list" class="list-group"></div>
                                    </div>
                                    <div class="col-md-3" style="font-size: 14px;">
                                        <div>PH: <span id="cus_phone"></span></div>
                                        <div>Due: <span id="cus_due"></span> &#2547;</div>
                                    </div>
                                </div>
                            </div>
                            <div class="block">
                                <div class="table-responsive">
                                    <table id="sales_table" class="table table-hover">
                                        <thead>
                                            <tr class="text-primary">
                                                <th scope="col" style="display: none">ID</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Batch</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Price (&#2547;)</th>
                                                <th scope="col">Total (&#2547;)</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        </tbody>

                                        <tfoot>
                                            <tr class="text-primary">
                                                <th scope="col" colspan="3" class="text-right">Totals:</th>
                                                <th id="t_qty" scope="col">0</th>
                                                <th></th>
                                                <th id="total" scope="col">0.00</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="my-3">
                                    <label for="sale_note">Sale Note:</label>
                                    <textarea class="form-control" id="sale_note" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="block px-0 py-2">
                                <table class="table table-hover" id="count_table" style="font-size: 13px;">
                                    <h6 class="text-center text-primary">CART TOTAL : <span id="cart_total">0</span> &#2547;</h6>
                                    <tbody>
                                        <tr class="d-none font-weight-bold">
                                            <td class="td_1">Discount <span id="dis_amt"></span></td>
                                            <td class="td_2" id="grand_discount">0</td>
                                        </tr>
                                        <tr>
                                            <td class="td_1">Total</td>
                                            <td class="td_2" id="grand_total">0</td>
                                        </tr>
                                        <tr>
                                            <td class="td_1">Paid</td>
                                            <td class="td_2" id="grand_paid">0</td>
                                        </tr>
                                        <tr>
                                            <td class="td_1" id="round_td">
                                                <div class="label-switch-wrapper">
                                                    <label for="round_check" class="m-0">Round</label>
                                                    <label class="switch">
                                                        <input id="round_check" type="checkbox">
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="td_2" id="grand_round">0</td>
                                        </tr>
                                        <tr class="text-primary">
                                            <td class="td_1">Total Due:</td>
                                            <td class="td_2" id="grand_due">0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="block">
                                <h4 class="text-primary pb-2" style="border-bottom: 2px solid #019bee;">Payment Option:</h4>
                                <div class="row payment-options">
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_cash">
                                            <input type="radio" name="radio_amount" id="radio_cash">
                                            <span>Cash</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_card">
                                            <input type="radio" name="radio_amount" id="radio_card">
                                            <span>Card</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_mob">
                                            <input type="radio" name="radio_amount" id="radio_mob">
                                            <span>Mobile</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_modal" id="multi_pay_btn" data-toggle="modal" data-target="#multi_pay">
                                            <input type="radio" name="radio_amount" id="radio_modal">
                                            <span>Multiple</span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="cash_amt" id="cash_amt" placeholder="Cash Amount">
                                    </div>
                                </div>
                                <div class="row pay_option" id="cash_field">
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="cash_paid" id="cash_paid" placeholder="Cash Paid">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="cash_change" id="cash_change" placeholder="Change Amount" readonly>
                                    </div>
                                </div>
                                <div class="row pay_option" id="card_field" style="display: none;">
                                    <div class="col-md-4">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="card_number" id="card_number" placeholder="Card Number">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control form-control-sm mb-3" name="card_type" id="card_type">
                                            <option value="">Card Type</option>

                                            @foreach ($cardnames as $cardname)
                                                <option value="{{ $cardname->id }}">
                                                    {{ $cardname->card_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control form-control-sm mb-3" name="bank_type" id="bank_type">
                                            <option value="">Select Bank</option>

                                            @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Bank')
                                                    <option value="{{ $account->id }}">
                                                        {{ $account->acc_name }} ({{ $account->acc_no }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row pay_option" id="mobile_field" style="display: none;">
                                    <div class="col-md-4">
                                        <select class="form-control form-control-sm mb-3" name="mobile_bank" id="mobile_bank">
                                            <option value="">Mobile Bank</option>

                                            @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Mobile')
                                                    <option value="{{ $account->id }}">
                                                        {{ $account->acc_name }} ({{ $account->acc_no }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="trans_no" id="trans_no" placeholder="Transaction No">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="rece_no" id="rece_no" placeholder="Reciever No">
                                    </div>
                                </div>
                                <div class="row multi_option d-none"></div>
                                <button class="btn btn-primary w-100 btn-sm my-2" id="add_sale_btn">Sale Now</button>
                            </div>
                            <div class="block d-flex flex-wrap">
                                <button class="btn btn-warning btn-sm px-4 mb-1 mx-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Discount" data-toggle="modal" data-target="#dis_modal"><i class="fa fa-percent"></i></button>
                                <button class="btn btn-danger btn-sm px-4 mb-1 mx-auto" id="hold_sale_btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hold Sale"><i class="fa fa-pause"></i></button>
                                <button class="btn btn-secondary btn-sm px-4 mb-1 mx-auto" data-toggle="modal" data-target="#sales_restore_modal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Restore"><i class="fa fa-rotate-left"></i></button>
                                <button class="btn btn-info btn-sm px-4 mb-1 mx-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Sale Replace"><i class="fa fa-arrows-rotate"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer Sections -->
            @include('admin.dash_footer')

        </div>
    </div>

    <!-- Discount Modal -->
    <div class="modal fade" id="dis_modal" tabindex="-1" role="dialog" aria-labelledby="dis_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="discount_modal">
                <div class="modal-header">
                    <h5 class="modal-title">Add Discount</h5>
                    <button type="button" class="close" id="dis_modal_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="mb-4">
                        <label class="form-label">Discount (%)</label>
                        <input type="text" class="form-control only_num" name="dis_per" id="dis_per">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Discount (&#2547;)</label>
                        <input type="text" class="form-control only_num" name="dis_tk" id="dis_tk">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="dis_submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Multi Pay Modal -->
    <div id="multi_pay" tabindex="-1" role="dialog" aria-labelledby="multi_payLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Multiple Payment</strong>
                    <button type="button" data-dismiss="modal" id="multi_pay_close" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Cash Amount</label>
                            <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="m_cash_amt" id="m_cash_amt" data-info="cash" placeholder="Enter Amount">
                        </div>
                        <div class="col-md-3">
                            <label for="">Card Amount</label>
                            <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="m_card_paid" id="m_card_paid" data-info="card"  placeholder="Enter Amount">
                        </div>
                        <div class="col-md-3">
                            <label for="">Card Number</label>
                            <input class="form-control form-control-sm mb-3 only_num" type="text" name="m_card_number" id="m_card_number" placeholder="Card Number">
                        </div>
                        <div class="col-md-3">
                            <label for="">Select Card</label>
                            <select class="form-control form-control-sm mb-3" name="m_card_type" id="m_card_type">
                                <option value="">Card Type</option>

                                @foreach ($cardnames as $cardname)
                                    <option value="{{ $cardname->id }}">
                                        {{ $cardname->card_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Select Bank</label>
                            <select class="form-control form-control-sm mb-3" name="m_bank_type" id="m_bank_type">
                                <option value="">Select Bank</option>

                                @foreach ($accounts as $account)
                                    @if ($account->account_type == 'Bank')
                                        <option value="{{ $account->id }}">
                                            {{ $account->acc_name }} ({{ $account->acc_no }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Mobile Amount</label>
                            <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="m_mobile_paid" id="m_mobile_paid" data-info="mob_bank" placeholder="Mobile Amount">
                        </div>
                        <div class="col-md-4">
                            <label for="">Transaction ID</label>
                            <input class="form-control form-control-sm mb-3 only_num" type="text" name="m_trans_no" id="m_trans_no" placeholder="Transaction No">
                        </div>
                        <div class="col-md-4">
                            <label for="">Select Mobile Bank</label>
                            <select class="form-control form-control-sm mb-3" name="m_mobile_bank" id="m_mobile_bank">
                                <option value="">Mobile Bank</option>

                                @foreach ($accounts as $account)
                                    @if ($account->account_type == 'Mobile')
                                        <option value="{{ $account->id }}">
                                            {{ $account->acc_name }} ({{ $account->acc_no }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="multi_cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="multi_submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- After_Sale Modal -->
    <div class="modal fade" id="saleSummaryModal" tabindex="-1" aria-labelledby="saleSummaryLabel" aria-hidden="true">
        <div class="modal-dialog" id="printModal">
            <div class="modal-content">
                <div class="modal-body p-5" id="saleSummaryContent">
                    {{-- Dynamic Content --}}
                </div>
                <div id="modal_footer" class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="print_close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="print_btn">Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Sales Restore Modal -->
    <div id="sales_restore_modal" tabindex="-1" role="dialog" aria-labelledby="sales_restore_modalmodal" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header"><strong id="category_modal" class="modal-title">Hold Sale List</strong>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close" id="restore_close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-primary">
                            <th scope="col">SL.</th>
                            <th scope="col">Invoice No</th>
                            <th scope="col">Held Products</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($heldSales as $heldSale)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{ $heldSale->invoiceNo }}</td>
                                <td>{{ $heldSale->held_products }}</td>
                                <td>{{ \Carbon\Carbon::parse($heldSale->date)->format('d M Y, h:i A') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm restore-sale-btn" data-invoice="{{ $heldSale->invoiceNo }}" data-count="{{ $heldSale->held_products }}">Restore</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>

    <!-- JS Files -->
    @include('admin.dash_script')
    <!-- Print JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.css">

    <!-- JS For product search -->
    <script>
        $(document).ready(function () {
            let exactMatch = false; // Track if a perfect match exists
            let formSubmitted = false; // Track if the form has already been submitted

            $('#product_search').on('keyup', function () {
                let query = $(this).val().trim();

                if (query.length > 0 && !formSubmitted) {
                    $.ajax({
                        url: "{{ route('search.sales.products') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            if (formSubmitted) return; // Stop processing if the form was already submitted
                            $('#product_search_list').empty(); // Clear existing suggestions
                            exactMatch = false; // Reset exact match status

                            if (data.length > 0) {
                                let oldestBatch = data[0]; // Always start with the first item as the oldest batch

                                // Check for an exact match
                                data.forEach(product => {
                                    if (product.title.toLowerCase() === query.toLowerCase() || product.barcode === query) {
                                        exactMatch = true;
                                    }

                                    // Populate suggestions
                                    $('#product_search_list').append(
                                        `<a href="#" class="list-group-item list-group-item-action" data-batch-no="${product.batch_no}">
                                            ${product.title} (${product.batch_no})
                                        </a>`
                                    );
                                });

                                // Auto-submit if an exact match is found
                                if (exactMatch && !formSubmitted) {
                                    formSubmitted = true; // Set flag to prevent further submissions
                                    $('#product_search').val(oldestBatch.title); // Set product title
                                    $('input[name="batch_no"]').val(oldestBatch.batch_no); // Set batch_no
                                    $('#product_search_list').empty(); // Clear suggestions
                                    $('#product_form').submit();
                                    // setTimeout(() => {
                                    // }, 500);

                                    // Reset the formSubmitted flag after submission
                                    setTimeout(() => {
                                        formSubmitted = false; // Allow future submissions
                                    }, 500); // Adjust delay if needed
                                }
                            } else {
                                $('#product_search_list').append(`<div class="list-group-item">No products found</div>`);
                            }
                        },
                        error: function () {
                            $('#product_search_list').append(`<div class="list-group-item">Error fetching products</div>`);
                        },
                    });
                } else {
                    $('#product_search_list').empty();
                }

            });

            // Ensure the suggestion list clears after form submission
            $('#product_form').on('submit', function () {
                $('#product_search_list').empty(); // Clear suggestions on form submission
            });

            // Fill inputs when a suggestion is clicked
            $(document).on('click', '.list-group-item-action', function (e) {
                e.preventDefault();
                const selectedText = $(this).text().split(' (')[0].trim(); // Extract title
                const batchNo = $(this).data('batch-no'); // Extract batch_no from data attribute

                $('#product_search').val(selectedText); // Set the title in the visible input
                $('input[name="batch_no"]').val(batchNo); // Set the batch_no in the hidden input
                $('#product_search_list').empty(); // Clear the suggestions

                $("#product_search").focus();

            });
        });
    </script>
    <!-- JS For customer search -->
    <script>
        $(document).ready(function () {
            $('#customer_search').on('keyup', function () {
                let query = $(this).val();

                // Clear the phone and due if the input is empty
                if (!query) {
                    $('#customer_search_list').html('');
                    $('#cus_phone').text(''); // Clear phone
                    $('#cus_due').text(''); // Clear due
                    $('#customerID').val(''); // Clear hidden customer ID
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
                                             data-id="${customer.id}" data-phone="${customer.phone.trim()}"
                                             data-due="${customer.due}">
                                             ${customer.name.trim()} (${customer.phone.trim()})
                                         </a>`;
                            });
                        } else {
                            html = '<a href="#" class="list-group-customer">No customers found</a>';
                        }

                        $('#customer_search_list').html(html);
                    },
                    error: function () {
                        $('#customer_search_list').html('<a href="#" class="list-group-customer">An error occurred</a>');
                    }
                });
            });

            // Event delegation for dynamically added elements
            $(document).on('click', '#customer_search_list .list-group-customer', function (e) {
                e.preventDefault();

                let selectedName = $(this).text().trim();
                let customerId = $(this).data('id');
                let customerPhone = $(this).data('phone').trim();
                let customerDue = $(this).data('due');

                $('#customer_search').val(selectedName);
                $('#customerID').val(customerId);
                $('#cus_phone').text(customerPhone);
                $('#cus_due').text(customerDue);
                $('#customer_search_list').html(''); // Clear the suggestions list
            });

            // Listen for changes to the #customer_search field
            $('#customer_search').on('input', function () {
                if (!$(this).val().trim()) {
                    $('#cus_phone').text(''); // Clear phone
                    $('#cus_due').text(''); // Clear due
                    $('#customerID').val(''); // Clear hidden customer ID
                    $('#customer_search_list').html(''); // Clear suggestions
                }
            });
        });
    </script>
    <!-- Other JS -->
    <script>
        $(document).ready(function () {
            // Initialize Bootstrap tooltips with a delay
            var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    delay: { "show": 500, "hide": 100 }  // 500ms delay before showing, 100ms before hiding
                })
            })

            // Restriction on text type input to enter anything other than Numbers
            $(document).on('input', '.only_num', function() {
                let value = $(this).val();
                if (!/^\d*\.?\d*$/.test(value)) { // Validates the decimal format
                    $(this).val(value.slice(0, -1)); // Remove the last invalid character
                }
            });

            // Monitor changes in #dis_per input field
            $('#dis_per').on('input', function () {
                if ($(this).val().trim() !== '') {
                    // Disable #dis_tk when #dis_per has a value
                    $('#dis_tk').prop('disabled', true);
                } else {
                    // Enable #dis_tk when #dis_per is empty
                    $('#dis_tk').prop('disabled', false);
                }
            });
            // Monitor changes in #dis_tk input field
            $('#dis_tk').on('input', function () {
                if ($(this).val().trim() !== '') {
                    // Disable #dis_per when #dis_tk has a value
                    $('#dis_per').prop('disabled', true);
                } else {
                    // Enable #dis_per when #dis_tk is empty
                    $('#dis_per').prop('disabled', false);
                }
            });
        });
    </script>
    <!-- JS for MultiPayment -->
    <script>
        $(document).ready(function () {
            // Show cash_field by default
            $('#cash_field').show();
            $('#card_field, #mobile_field').hide();

            // Toggle fields based on radio selection
            $('input[name="radio_amount"]').on('click', function () {
                const selectedId = $(this).attr('id');
                $('#cash_field, #card_field, #mobile_field').hide(); // Hide all fields
                if (selectedId === 'radio_cash') {
                    $('#cash_field').show();
                } else if (selectedId === 'radio_card') {
                    $('#card_field').show();
                } else if (selectedId === 'radio_mob') {
                    $('#mobile_field').show();
                }
            });

            // When "Multiple" radio is clicked, disable other radios
            $('#radio_modal').on('click', function () {
                $('input[name="radio_amount"]').not(this).prop('disabled', true); // Disable all other radios
            });

            // When the Cancel button is clicked, re-enable the other radios
            $('#multi_cancel').on('click', function () {
                $('input[name="radio_amount"]').prop('disabled', false); // Re-enable all radios
                $('#radio_modal').prop('checked', false); // Uncheck the "Multiple" radio

                // Clear appended divs and reset multiTotal
                $('.multi_option').empty();
                $('#grand_paid').text('0.00');
                $('#cash_amt').val('0.00');
                $('#grand_due').text($('#grand_total').text()); // Reset due to grand total

                // Programmatically trigger the click event on #multi_pay_close
                $('#multi_pay_close').click();
            });

            $('#multi_submit').on('click', function () {
                // Clear previous appended divs
                $('.multi_option').empty();

                $('.pay_option').hide();
                $('.multi_option').removeClass('d-none');

                var cashAmt = parseFloat($('#m_cash_amt').val());
                var cardAmt = parseFloat($('#m_card_paid').val());
                var mobileAmt = parseFloat($('#m_mobile_paid').val());

                const m_cardNumber = $('#m_card_number').val();
                const m_cardType = $('#m_card_type').val();
                const m_bankType = $('#m_bank_type').val();
                const m_mobTrans = $('#m_trans_no').val();
                const m_mobBank = $('#m_mobile_bank').val();

                // Validating when card paying option is selected
                if (cardAmt > 0) {
                    // Check if card number is null or empty
                    if (!m_cardNumber) {
                        alert("Enter Card number to proceed!");
                        return;
                    }

                    // Check if card type is not selected
                    if (!m_cardType) {
                        alert("Select a Card type to proceed!");
                        return;
                    }

                    // Check if bank type is not selected
                    if (!m_bankType) {
                        alert("Select a Bank to proceed!");
                        return;
                    }
                }

                // Validating when mobile paying option is selected
                if (mobileAmt > 0) {
                    // Check if card type is not selected
                    if (!m_mobTrans) {
                        alert("Enter transaction no. to proceed!");
                        return;
                    }

                    // Check if card number is null or empty
                    if (!m_mobBank) {
                        alert("Select a mobile bank to proceed!");
                        return;
                    }
                }

                let multiTotal = 0;

                if (cashAmt > 0) {
                    multiTotal += cashAmt;
                    $('.multi_option').append("<div class='col-md-4 mb-2'> Cash: <span class='m_cashAmt'>" + cashAmt + "</span> &#2547;</div>");
                }

                if (cardAmt > 0) {
                    var cardNumber = $('#m_card_number').val();
                    var cardType = $('#m_card_type').val();
                    var cardBank = $('#m_bank_type').val();
                    multiTotal += cardAmt;
                    $('.multi_option').append("<div class='col-md-4 mb-2'> Card: <span class='m_cardAmt'>" + cardAmt + "</span> &#2547;</div>");
                }

                if (mobileAmt > 0) {
                    var mobTrans = $('#m_trans_no').val();
                    var mobBank = $('#m_mobile_bank').val();
                    multiTotal += mobileAmt;
                    $('.multi_option').append("<div class='col-md-4 mb-2'> Mobile: <span class='m_mobAmt'>" + mobileAmt + "</span> &#2547;</div>");
                }

                $('#grand_paid').text(multiTotal.toFixed(2));
                var grandDue = parseFloat($('#grand_total').text()) - multiTotal;
                $('#cash_amt').val(multiTotal.toFixed(2));
                $('#grand_due').text(grandDue.toFixed(2));

                // Programmatically trigger the click event on #multi_pay_close
                $('#multi_pay_close').click();
            });
        });
    </script>
    <!-- JS For Sales -->
    <script>
        const stocks = @json($stocks);
        const restoreSale = @json($restoreSale);
    </script>
    <script>
        $(document).ready(function () {
            function updateTotals() {
                let totalQuantity = 0;
                let totalOfAll = 0;

                // Loop through each row in the sales table
                $('#sales_table tbody tr').each(function () {
                    const saleQty = parseFloat($(this).find('.so-qty-input').val()) || 0;
                    const totalPrice = parseFloat($(this).find('.total-input').val()) || 0;

                    totalQuantity += saleQty;
                    totalOfAll += totalPrice;
                });

                // Update table footer with total quantity and price
                $('#sales_table tfoot #t_qty').text(totalQuantity.toFixed(2));
                $('#sales_table tfoot #total').text(totalOfAll.toFixed(2));

                // Update cart total
                $('#cart_total').text(totalOfAll.toFixed(2));

                // Fetch user inputs for discount
                const disPer = parseFloat($('#dis_per').val()) || 0; // Percentage discount
                const disTk = parseFloat($('#dis_tk').val()) || 0;   // Direct value discount
                let discount = 0;

                // Calculate discount
                if (disPer > 0) {
                    discount = (disPer / 100) * totalOfAll;
                } else if (disTk > 0) {
                    discount = disTk;
                }

                // Ensure discount does not exceed totalOfAll
                if (discount > totalOfAll) {
                    discount = totalOfAll;
                }

                // Update discounted total
                const discountedTotal = totalOfAll - discount;

                // Remove `d-none` class if there is a discount, else add it
                if (discount > 0) {
                    $('#count_table tbody tr.d-none').removeClass('d-none');
                    $('#count_table #dis_amt').eq(0).text(`${disPer > 0 ? disPer + '%' : disTk + 'TK'}`);
                    $('#count_table .td_2').eq(0).text(discountedTotal.toFixed(2));
                } else {
                    $('#count_table tbody tr').eq(0).addClass('d-none');
                }

                // Set cash amount and update paid to discounted total
                if (!$('#cash_amt').data('user-modified')) {
                    $('#cash_amt').val(discountedTotal.toFixed(2));  // Set only if not modified by user
                }

                const actCashAmt = (parseFloat($('#cash_amt').val()) || 0);

                const paid = actCashAmt;

                // Calculate total due
                const round = $('#round_check').is(':checked') ? 0 : 0; // Initially no round applied
                let totalDue = (discountedTotal - paid);

                // Handle rounding
                if ($('#round_check').is(':checked')) {
                    $('#count_table #grand_round').text(totalDue.toFixed(2)); // Set round value to due amount
                    totalDue = 0; // Set total due to 0
                } else {
                    $('#count_table #grand_round').text(round.toFixed(2)); // Reset round value to 0
                }

                // Update fields in count_table
                $('#count_table .td_2').eq(1).text(discountedTotal.toFixed(2));
                $('#count_table .td_2').eq(2).text(paid.toFixed(2));  // Paid amount
                $('#count_table .td_2').eq(4).text(totalDue.toFixed(2)); // Total due

                // Set default cash_paid to null (if not modified)
                if (!$('#cash_paid').data('user-modified')) {
                    $('#cash_paid').val(actCashAmt.toFixed(2));
                }

                // Set cash_change to null initially (if not modified by user)
                if (!$('#cash_change').data('user-modified')) {
                    $('#cash_change').val(null);
                }

                // Update change amount (based on cash_paid input)
                const cashPaid = parseFloat($('#cash_paid').val()) || 0;
                const cashChange = cashPaid - parseFloat($('#cash_amt').val()) || 0;
                $('#cash_change').val(cashChange.toFixed(2));
            }

            // Event listener for the discount submission button
            $('#dis_submit').on('click', function () {
                $('#discount_modal').modal('hide');
                updateTotals();
                $('#dis_modal_close').click();
            });

            // Detect changes to the #cash_amt field
            $('#cash_amt').on('input', function () {
                $(this).data('user-modified', true);
                updateTotals();
            });

            // Detect changes to the #cash_paid field
            $('#cash_paid').on('input', function () {
                $(this).data('user-modified', true);
                updateTotals();
            });

            // Recalculate totals when the round checkbox changes
            $('#round_check').on('change', function () {

                if ($('#round_check').is(':checked')) {
                    $('#count_table #grand_round').text(parseFloat($('#grand_due').text()).toFixed(2));
                    $('#grand_due').text('0.00');
                } else {
                    $('#grand_due').text(parseFloat($('#grand_round').text()).toFixed(2));
                    $('#count_table #grand_round').text('0.00');
                }

            });

            // Trigger updateTotals initially to set values
            updateTotals();

            // Handle form submission
            $('#product_form').on('submit', function (e) {
                e.preventDefault();

                // Get form values
                const productName = $('input[name="product"]').val().trim();
                const productBatch = $('input[name="batch_no"]').val().trim();

                // Find all batches for the given product
                const productStocks = stocks.filter(p => p.product_name === productName);

                if (!productStocks.length) {
                    // alert("Product not found.");
                    return;
                }

                // Find the selected batch
                const stock = productStocks.find(p => String(p.batch_no) === String(productBatch));

                if (!stock) {
                    toastr.warning('Product with the specified batch not found!');
                    return;
                }

                // Check if the product with the same batch already exists in the table
                const existingRow = $('#sales_table tbody tr').toArray().find(row => {
                    const productName = $(row).find('td:nth-child(2)').text().trim();
                    const batchNo = $(row).find('td:nth-child(3) select').val();
                    return String(productName) === String(stock.product_name) && String(batchNo) === String(stock.batch_no);
                });

                if (existingRow) {
                    // If the row exists, increment the quantity by 1
                    const qtyInput = $(existingRow).find('.so-qty-input');
                    const availableStock = parseFloat($(existingRow).find('.qty-input').val()) || 0;

                    if (Number(qtyInput.val()) + 1 > availableStock) {
                        alert(`Cannot exceed available stock (${availableStock}).`);
                        return;
                    }

                    qtyInput.val(Number(qtyInput.val()) + 1);

                    // Update the total
                    const price = parseFloat($(existingRow).find('.price-input').val());
                    const totalInput = $(existingRow).find('.total-input');
                    totalInput.val(price * Number(qtyInput.val()));
                } else {
                    // Append a new row if the product with the batch doesn't exist
                    $('#sales_table tbody').append(
                        `<tr>
                            <td style="display: none">${stock.product_id}</td>
                            <td>${stock.product_name}</td>
                            <td>
                                <select class="form-control form-control-sm batch-input">
                                    ${productStocks
                                        .map(batch => `<option value="${batch.batch_no}" ${batch.batch_no === stock.batch_no ? 'selected' : ''}>${batch.batch_no}</option>`)
                                        .join('')}
                                </select>
                            </td>
                            <td><input type="number" class="form-control form-control-sm qty-input" value="${stock.quantity}" readonly></td>
                            <td><input type="number" class="form-control form-control-sm so-qty-input" value="1" min="1"></td>
                            <td><input type="number" class="form-control form-control-sm price-input" value="${stock.sale_price}" readonly></td>
                            <td><input type="number" class="form-control form-control-sm total-input" value="${stock.sale_price}" readonly></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>`
                    );
                }

                // Reset the form fields and update the totals
                this.reset();
                updateTotals();
            });

            // Restrict duplicate batch selection in the dropdown
            $(document).on('change', '.batch-input', function () {
                const selectedBatch = $(this).val();
                const productName = $(this).closest('tr').find('td:nth-child(2)').text().trim();

                // Check if the selected batch with the same product already exists in the table
                const isDuplicate = $('#sales_table tbody tr').toArray().some(row => {
                    const rowProductName = $(row).find('td:nth-child(2)').text().trim();
                    const rowBatchNo = $(row).find('.batch-input').val();
                    return rowProductName === productName && rowBatchNo === selectedBatch && row !== $(this).closest('tr')[0];
                });

                if (isDuplicate) {
                    alert('This batch number already exist.');
                    // Revert to the previous value
                    $(this).val($(this).data('previous'));
                } else {
                    // Store the current value as the previous value for next change
                    $(this).data('previous', selectedBatch);
                }
            });

            // Store the initial value of the dropdown on page load
            $(document).on('focus', '.batch-input', function () {
                $(this).data('previous', $(this).val());
            });

            // Update quantity and price when the batch changes
            $(document).on('change', '.batch-input', function () {
                const $row = $(this).closest('tr');
                const selectedBatch = $(this).val(); // Get the selected batch number
                const productName = $row.find('td:nth-child(2)').text(); // Get the product name

                // Find the corresponding stock for the selected batch
                const stock = stocks.find(p => p.product_name === productName && String(p.batch_no) === String(selectedBatch));

                if (stock) {
                    // Update the quantity and sale price
                    $row.find('.qty-input').val(stock.quantity);
                    $row.find('.price-input').val(stock.sale_price);

                    // Update the total price based on the new batch
                    const saleQty = parseFloat($row.find('.so-qty-input').val()) || 0;
                    const total = saleQty * stock.sale_price; // Calculate the total price
                    $row.find('.total-input').val(total.toFixed(2));
                } else {
                    alert("Batch information not found.");
                }

                // Recalculate totals
                updateTotals();
            });

            // Update total-input dynamically based on so-qty-input and validate against quantity
            $(document).on('input', '.so-qty-input', function () {
                const $row = $(this).closest('tr');
                const qtyInput = parseFloat($row.find('.qty-input').val()) || 0;
                const saleQty = parseFloat($(this).val()) || 0;

                if (saleQty > qtyInput) {
                    alert(`Sale quantity cannot exceed available stock. Available stock is: ${qtyInput}`);
                    $(this).val(""); // Reset the sale quantity input
                    $row.find('.total-input').val("0.00"); // Reset total price
                } else {
                    const price = parseFloat($row.find('.price-input').val());
                    const total = saleQty * price;
                    $row.find('.total-input').val(total.toFixed(2));
                }

                // Recalculate totals
                updateTotals();
            });

            // Remove row and update totals
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                updateTotals();
            });

            // Declare variables
            let r_cashPay = 0, r_cardPay = 0, r_mobilePay = 0, r_multPay = 0;

            // Add change event listener to the radio buttons
            $('input[name="radio_amount"]').on('change', function () {
                // Get the value of #cash_amt
                let r_cashAmt = $('#cash_amt').val();

                // Check which radio button is selected and assign the value accordingly
                if ($('#radio_cash').is(':checked')) {
                    r_cashPay = r_cashAmt;
                    r_cardPay = 0;
                    r_mobilePay = 0;
                    r_multPay = 0;
                } else if ($('#radio_card').is(':checked')) {
                    r_cardPay = r_cashAmt;
                    r_cashPay = 0;
                    r_mobilePay = 0;
                    r_multPay = 0;
                } else if ($('#radio_mob').is(':checked')) {
                    r_mobilePay = r_cashAmt;
                    r_cashPay = 0;
                    r_cardPay = 0;
                    r_multPay = 0;
                } else if ($('#radio_modal').is(':checked')) {
                    r_multPay = r_cashAmt;
                    r_cashPay = 0;
                    r_cardPay = 0;
                    r_mobilePay = 0;
                }
            });

            // Optionally, handle input changes for #cash_amt
            $('#cash_amt').on('input', function () {
                $('input[name="radio_amount"]:checked').trigger('change');
            });

            // Sending Data to the BackEnd -------------->
            $('#add_sale_btn').on('click', function () {

                const cashTotal = parseFloat($('#grand_total').text() || "0.00").toFixed(2);
                const cashDiscount = $('#dis_amt').text() || "0.00";
                const cashRound = parseFloat($('#grand_round').text() || "0.00").toFixed(2);
                const cashDue = parseFloat($('#grand_due').text() || "0.00").toFixed(2);
                const customer_id = $('#customerID').val();

                const cashAmount = parseFloat($('#cash_amt').val() || "0.00").toFixed(2);
                const s_cashPaid = parseFloat($('#grand_paid').text() || "0.00").toFixed(2);
                const s_cashChange = parseFloat($('#cash_change').val() || "0.00").toFixed(2);

                let cashPay;
                if (!$('input[name="radio_amount"]').is(':checked')) {
                    cashPay = parseFloat($('#cash_amt').val() || "0.00").toFixed(2);
                } else {
                    cashPay = parseFloat(r_cashPay).toFixed(2);
                }

                const cardPay = parseFloat(r_cardPay).toFixed(2);
                const mobilePay = parseFloat(r_mobilePay).toFixed(2);
                const multPay = parseFloat(r_multPay).toFixed(2);

                const s_cardNumber = $('#card_number').val();
                const s_cardType = $('#card_type').val();
                const s_bankType = $('#bank_type').val();
                const s_mobBank = $('#mobile_bank').val();
                const s_mobTrans = $('#trans_no').val();
                const s_mobRcv = $('#rece_no').val();

                const m_cashAmt = parseFloat($('.m_cashAmt').text() || 0).toFixed(2);
                const m_cardAmt = parseFloat($('.m_cardAmt').text() || 0).toFixed(2);
                const m_mobAmt = parseFloat($('.m_mobAmt').text() || 0).toFixed(2);

                const m_cardNumber = $('#m_card_number').val();
                const m_cardType = $('#m_card_type').val();
                const m_bankType = $('#m_bank_type').val();
                const m_mobTrans = $('#m_trans_no').val();
                const m_mobBank = $('#m_mobile_bank').val();

                let invoice_no = Date.now();

                // Validate required fields
                if (cashTotal == 0) {
                    alert('Please Select a Product to proceed!');
                    return;
                }

                if (cashDue > 0 && !customer_id) {
                    alert('Please enter a Customer to have Due!');
                    return;
                }

                // Validating when card paying option is selected
                if (cardPay > 0) {
                    // Check if card number is null or empty
                    if (!s_cardNumber) {
                        alert("Enter Card number to proceed!");
                        return;
                    }

                    // Check if card type is not selected
                    if (!s_cardType) {
                        alert("Select a Card type to proceed!");
                        return;
                    }

                    // Check if bank type is not selected
                    if (!s_bankType) {
                        alert("Select a Bank to proceed!");
                        return;
                    }
                }

                // Validating when mobile paying option is selected
                if (mobilePay > 0) {
                    // Check if card number is null or empty
                    if (!s_mobBank) {
                        alert("Select a mobile bank to proceed!");
                        return;
                    }

                    // Check if card type is not selected
                    if (!s_mobTrans) {
                        alert("Enter transaction no. to proceed!");
                        return;
                    }

                    // Check if bank type is not selected
                    if (!s_mobRcv) {
                        alert("Enter Reciever no. to proceed!");
                        return;
                    }
                }

                const rows = [];

                // Loop through each row in the table and collect row data
                $('#sales_table tbody tr').each(function () {
                    rows.push({
                        product_id: $(this).find('td:eq(0)').text(),
                        product_name: $(this).find('td:eq(1)').text(),
                        batch_no: $(this).find('.batch-input').val(),
                        so_qty: parseFloat($(this).find('.so-qty-input').val()) || 0,
                        price: parseFloat($(this).find('.price-input').val()) || 0,
                        total_price: parseFloat($(this).find('.total-input').val()) || 0,
                    });
                });

                // Preparing the Sales infos
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('invoice_no', invoice_no);
                formData.append('cash_total', cashTotal);
                formData.append('cash_dis', cashDiscount);
                formData.append('cash_round', cashRound);
                formData.append('cash_due', cashDue);
                formData.append('customerID', customer_id);

                formData.append('s_cash_amt', cashPay);
                formData.append('m_cash_amt', m_cashAmt);
                formData.append('s_cash_paid', s_cashPaid);
                formData.append('s_cash_change', s_cashChange);

                formData.append('s_card_amt', cardPay);
                formData.append('m_card_amt', m_cardAmt);
                formData.append('s_card_num', s_cardNumber);
                formData.append('m_card_num', m_cardNumber);
                formData.append('s_card_type', s_cardType);
                formData.append('m_card_type', m_cardType);
                formData.append('s_bank_type', s_bankType);
                formData.append('m_bank_type', m_bankType);

                formData.append('s_mob_amt', mobilePay);
                formData.append('m_mob_amt', m_mobAmt);
                formData.append('s_mob_bank', s_mobBank);
                formData.append('m_mob_bank', m_mobBank);
                formData.append('s_mob_trans', s_mobTrans);
                formData.append('m_mob_trans', m_mobTrans);
                formData.append('s_mob_rcv', s_mobRcv);

                formData.append('rows', JSON.stringify(rows));

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("save.sales") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Save response to local storage
                        localStorage.setItem('saleSummary', JSON.stringify(response));

                        // Reload the page
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred: ' + xhr.responseText);
                    },
                });
            });

            // Hold Sales Script
            $('#hold_sale_btn').on('click', function () {

                let invoiceNo = Date.now();
                const rows = [];

                // Loop through each row in the table and collect row data
                $('#sales_table tbody tr').each(function () {
                    rows.push({
                        product_id: $(this).find('td:eq(0)').text(),
                        product_name: $(this).find('td:eq(1)').text(),
                        batch_no: $(this).find('.batch-input').val(),
                        so_qty: parseFloat($(this).find('.so-qty-input').val()) || 0,
                        price: parseFloat($(this).find('.price-input').val()) || 0,
                        total_price: parseFloat($(this).find('.total-input').val()) || 0,
                    });
                });

                // Check if rows are empty
                if (rows.length === 0) {
                    toastr.warning('Select a product to hold sale!');
                    return;
                }

                // Preparing the Sales infos
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('invoiceNo', invoiceNo);
                formData.append('rows', JSON.stringify(rows));

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("hold.sales") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred: ' + xhr.responseText);
                    },
                });
            });

            // Restore sales Script
            $('.restore-sale-btn').on('click', function () {
                const invoiceNo = $(this).attr('data-invoice').trim();
                const product_count = $(this).attr('data-count').trim();
                const invoice_item = restoreSale.filter(p => p.invoiceNo === invoiceNo);

                for (const element of invoice_item) {
                    const productName = element.product_name;
                    const productBatch = element.batch_no;
                    const productStocks = stocks.filter(p => p.product_name === productName);

                    if (!productStocks.length) {
                        alert("Product not found.");
                        return;
                    }

                    const stock = productStocks.find(p => String(p.batch_no) === String(productBatch));
                    if (!stock) {
                        alert("Product with the specified batch not found.");
                        return;
                    }

                    const existingRow = $('#sales_table tbody tr').toArray().find(row => {
                        const productName = $(row).find('td:nth-child(2)').text().trim();
                        const batchNo = $(row).find('td:nth-child(3) select').val();
                        return String(productName) === String(stock.product_name) && String(batchNo) === String(stock.batch_no);
                    });

                    if (existingRow) {
                        const qtyInput = $(existingRow).find('.so-qty-input');
                        const availableStock = parseFloat($(existingRow).find('.qty-input').val()) || 0;

                        if (Number(qtyInput.val()) + 1 > availableStock) {
                            alert(`Cannot exceed available stock (${availableStock}).`);
                            return;
                        }

                        qtyInput.val(Number(qtyInput.val()) + 1);
                        const price = parseFloat($(existingRow).find('.price-input').val());
                        const totalInput = $(existingRow).find('.total-input');
                        totalInput.val(price * Number(qtyInput.val()));
                    } else {
                        $('#sales_table tbody').append(
                            `<tr>
                                <td style="display: none">${stock.product_id}</td>
                                <td>${stock.product_name}</td>
                                <td>
                                    <select class="form-control form-control-sm batch-input">
                                        ${productStocks
                                            .map(batch => `<option value="${batch.batch_no}" ${batch.batch_no === stock.batch_no ? 'selected' : ''}>${batch.batch_no}</option>`)
                                            .join('')}
                                    </select>
                                </td>
                                <td><input type="number" class="form-control form-control-sm qty-input" value="${stock.quantity}" readonly></td>
                                <td><input type="number" class="form-control form-control-sm so-qty-input" value="1" min="1"></td>
                                <td><input type="number" class="form-control form-control-sm price-input" value="${stock.sale_price}" readonly></td>
                                <td><input type="number" class="form-control form-control-sm total-input" value="${stock.sale_price}" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>`
                        );
                    }
                    updateTotals();
                }

                // AJAX request to delete the record from the database
                $.ajax({
                    url: '/delete-hold-sale', // Adjust the route as needed
                    type: 'POST',
                    data: {
                        invoiceNo: invoiceNo,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "5000",
                            "positionClass": "toast-top-right"
                        };
                        toastr.success(response.message, "Success!");

                        // Remove the row from the table
                        $(`button[data-invoice="${invoiceNo}"]`).closest('tr').remove();
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "5000",
                            "positionClass": "toast-top-right"
                        };
                        toastr.error("Error deleting the record.", "Error!");
                    }
                });

                // Programmatically trigger the click event on Modal
                $('#restore_close').click();
            });
        });
    </script>
    <!-- JS for AfterSale Modal -->
    <script>
        $(document).ready(function () {
            function getFormattedDateTime() {
                const now = new Date();

                const months = [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ];

                const day = now.getDate();
                const month = months[now.getMonth()];
                const year = now.getFullYear();

                let hours = now.getHours();
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'

                return `${day} ${month}, ${year} ${hours}:${minutes} ${ampm}`;
            }

            // Example usage
            const dateTime = getFormattedDateTime();

            // Check if there is stored sale summary data
            let saleSummary = localStorage.getItem('saleSummary');
            if (saleSummary) {
                let response = JSON.parse(saleSummary);

                // Populate the modal with the stored data
                let summaryHtml = `
                    <div id="p_top" class="text-center">
                        <h5 id="p_head" style="font-size: 25px; font-weight: 400;">SAFI2 SUPER SHOP</h5>
                        <p id="p_address" style="font-size: 13px;">Taleb Ali Mosjid Road,Nijumbag,Sarulia,Demra,Dhaka -1361</p>
                        <hr style="border: 1px solid black; margin: 0px;">
                        <p id="p_vat" class="m-0">VAT Reg:</p>
                        <hr style="border: 1px solid black; margin: 0px;">
                    </div>
                    <div id="p_info" class="my-1" style="font-size: 13px;">
                        <p class="m-0" style="line-height: 1.1;">
                            ServedBy: ${response.user}
                        </p>
                        <p class="m-0" style="line-height: 1.1;">
                            Date: ${dateTime}
                        </p>
                        <p class="m-0" style="line-height: 1.1;">
                            Customer Name: ${response.customer_name}
                        </p>
                    </div>
                    <h5 id="p_invoice" class="text-center" style="font-size: 18px; font-weight: 400;">Invoive: ${response.invoiceNo}</h5>
                    <table class="table" border="0">
                        <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                            <tr>
                                <td>Product</td>
                                <td>U.Price</td>
                                <td>Qty</td>
                                <td>Total(&#2547;)</td>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px;">
                            ${response.rows.map(row => `
                                <tr>
                                    <td>${row.product_name}</td>
                                    <td>${parseFloat(row.price).toFixed(2)}</td>
                                    <td>${parseFloat(row.so_qty).toFixed(2)}</td>
                                    <td>${parseFloat(row.total_price).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                        <tfoot>
                            <tr class="bottom_border" style="border-bottom: 2px solid black;">
                                <td colspan="2">${response.items} Items</td>
                                <td>${parseFloat(response.total_qty).toFixed(2)}</td>
                                <td>${parseFloat(response.total_price).toFixed(2)}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Discount</td>
                                <td>${response.discount}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Round:</td>
                                <td>${response.cashRound}</td>
                            </tr>
                            <tr class="bottom_border" style="border-bottom: 2px solid black;">
                                <td colspan="3">Net Amount (&#2547;)</td>
                                <td>${response.cashTotal}</td>
                            </tr>
                            <tr class="dash_border" style="border-bottom:1px dashed black;">
                                <td colspan="3">Payment Type</td>
                                <td>Amount</td>
                            </tr>
                            ${response.cashAmount > 0 ? `
                                <tr>
                                    <td colspan="3">Cash</td>
                                    <td>${parseFloat(response.cashAmount).toFixed(2)}</td>
                                </tr>
                            ` : ''}
                            ${response.cardAmount > 0 ? `
                                <tr>
                                    <td colspan="3">Card</td>
                                    <td>${parseFloat(response.cardAmount).toFixed(2)}</td>
                                </tr>
                            ` : ''}
                            ${response.mobileAmount > 0 ? `
                                <tr>
                                    <td colspan="3">Mobile</td>
                                    <td>${parseFloat(response.mobileAmount).toFixed(2)}</td>
                                </tr>
                            ` : ''}
                            <tr class="bottom_border" style="border-bottom: 2px solid black;" class="mt-1">
                                <td colspan="3">Total Paid:</td>
                                <td>${parseFloat(response.totalPaidAmt).toFixed(2)}</td>
                            </tr>
                            <tr class="mt-2">
                                <td colspan="3">Paid Amount:</td>
                                <td>${response.cashPaid}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Due Amount:</td>
                                <td>${response.cashDue}</td>
                            </tr>
                            <tr class="dash_border" style="border-bottom: 1px dashed black;">
                                <td colspan="3">Change Amt:</td>
                                <td>${response.cashChange}</td>
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
                `;

                // Insert the HTML into the modal content
                $('#saleSummaryContent').html(summaryHtml);

                // Show the modal
                $('#saleSummaryModal').modal('show');

                // Clear the stored data
                localStorage.removeItem('saleSummary');
            }
        });
    </script>
    <!-- Script for Print -->
    <script>
        $(document).ready(function () {
            $(document).on('click', '#print_btn', function () {
                // Temporarily hide #modal_footer
                $('#modal_footer').hide();

                // Use a slight delay to ensure the print dialog is triggered first
                setTimeout(function () {
                    printJS({
                        printable: 'printModal',
                        type: 'html',
                        css: [
                            '{{ asset("admin_css/css/print.css") }}',
                            '{{ asset("admin_css/vendor/bootstrap/css/bootstrap.min.css") }}',
                        ]
                    });

                    // Restore #modal_footer after the print attempt
                    $('#modal_footer').show();
                }, 100);  // Short delay to ensure printJS runs first
            });
        });
    </script>

  </body>
</html>
