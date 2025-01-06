<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>Admin - Stock In Summary</title>
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
            <h2 class="h5 no-margin-bottom">Reports / Stock In Summary</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('search.stockIn.summary') }}" method="POST" id="stockIn_sum_form">
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
                                    <div class="col-lg-3 col-md-4 mb-3 position-relative">
                                        <label>Product Name/Code</label>
                                        <input type="text" id="product-search_stock" name="product" class="form-control form-control-sm" placeholder="Search Product..." autocomplete="off">
                                        <input type="hidden" id="productID" name="productID">
                                        <div id="product-list_stock" class="list-group"></div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">Batch Number</label>
                                        <input type="number" class="form-control form-control-sm" name="batchNo">
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Product Category</label>
                                        <select class="form-control form-control-sm form-select" name="category" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($categories as $category)
                                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">Sub Category</label>
                                        <select class="form-control form-control-sm form-select" name="subcategory" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{$subcategory->sub_category}}">{{$subcategory->sub_category}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">Brand</label>
                                        <select class="form-control form-control-sm form-select" name="brand" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($brands as $brand)
                                                <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3 position-relative">
                                        <label class="form-label">Supplier</label>
                                        <input type="text" id="supplier_search" name="supplier" class="form-control form-control-sm" autocomplete="off" placeholder="Search Supplier...">
                                        <input type="hidden" name="supplierID" id="supplierID">
                                        <div id="supplier_search_list" class="list-group" style="width: 90%;"></div>
                                    </div>

                                    <div class="col-lg-2 col-md-4 my-2">
                                        <button type="submit" class="btn btn-primary mt-md-3 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- @if ($sales->isNotEmpty())
                            <div class="block table-responsive">
                                <h5 class="text-center">Product Sales From: {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} &nbsp;- To: {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</h5>
                                <table class="table table-hover" id="product_sales_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Invoice No</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Batch Number</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Category/Subcategory</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d M, Y') }}</td>
                                                <td>{{$sale->sales_invoice}}</td>
                                                <td>{{$sale->product_name}}</td>
                                                <td>{{$sale->batch_no}}</td>
                                                <td>{{$sale->customer_name ?? 'N/A'}}</td>
                                                <td>{{$sale->product_cat}}/{{$sale->product_sub_cat}}</td>
                                                <td>{{$sale->product_brand}}</td>
                                                <td>{{$sale->price}}</td>
                                                <td>{{$sale->so_qty}}</td>
                                                <td>{{$sale->total}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" colspan="9" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif --}}
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
            $('#stockIn_sum_form').on('submit', function (e) {
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
    <!-- JS For product search -->
    <script>
        $(document).ready(function() {
            $('#product-search_stock').on('keyup', function() {
                let query = $(this).val();
                if (query.length > 0) { // Changed from > 1 to > 0
                    $.ajax({
                        url: "{{ route('search.products') }}",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            $('#product-list_stock').empty();
                            if (data.length > 0) {
                                data.forEach(product => {
                                    $('#product-list_stock').append(`<a href="#" class="list-group-item list-group-item-action" data-id="${product.id}">${product.title}</a>`);
                                });
                            } else {
                                $('#product-list_stock').append(`<div class="list-group-item">No products found</div>`);
                            }
                        }
                    });
                } else {
                    $('#product-list_stock').empty();
                }
            });

            // Fill input when suggestion is clicked
            $(document).on('click', '.list-group-item-action', function(e) {
                e.preventDefault();

                let productId = $(this).data('id');

                $('#product-search_stock').val($(this).text());
                $('#productID').val(productId);
                $('#product-list_stock').empty();
            });
        });
    </script>
    <!-- JS For Supplier search -->
    <script>
        $(document).ready(function () {
            $('#supplier_search').on('keyup', function () {
                let query = $(this).val();

                // Clear the phone and due if the input is empty
                if (!query) {
                    $('#supplier_search_list').html('');
                    $('#customerID').val(''); // Clear hidden customer ID
                    return;
                }

                $.ajax({
                    url: "{{ route('search.suppliers') }}",
                    type: "GET",
                    data: { query: query },
                    success: function (data) {
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(supplier => {
                                html += `<a href="#" class="list-group-supplier list-group-supplier-action" data-id="${supplier.id}">
                                            ${supplier.supplier_name.trim()}</a>`;
                            });
                        } else {
                            html = '<a href="#" class="list-group-supplier">No supplier found</a>';
                        }

                        $('#supplier_search_list').html(html);
                    },
                    error: function () {
                        $('#supplier_search_list').html('<a href="#" class="list-group-supplier">An error occurred</a>');
                    }
                });
            });

            // Event delegation for dynamically added elements
            $(document).on('click', '#supplier_search_list .list-group-supplier', function (e) {
                e.preventDefault();

                let selectedName = $(this).text().trim();
                let supplierId = $(this).data('id');

                $('#supplier_search').val(selectedName);
                $('#supplierID').val(supplierId);
                $('#supplier_search_list').html('');
            });

            // Listen for changes to the #supplier_search field
            $('#supplier_search').on('input', function () {
                if (!$(this).val().trim()) {
                    $('#supplierID').val('');
                    $('#supplier_search_list').html(''); // Clear suggestions
                }
            });
        });
    </script>
    <!-- Updating Table Footer based on the table rows -->
    <script>
        $(document).ready(function () {
            function updateFooterTotals() {
                let totalQty = 0;
                let totalPrice = 0;

                // Iterate through each row in the tbody
                $("#product_sales_table tbody tr").each(function () {
                    totalQty += parseFloat($(this).find("td").eq(9).text()) || 0;
                    totalPrice += parseFloat($(this).find("td").eq(10).text()) || 0;
                });

                // Update the footer with the calculated totals
                let $tfoot = $("#product_sales_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalQty.toFixed(2));
                $tfoot.find("th").eq(2).text(totalPrice.toFixed(2));
            }

            // Call the function on page load
            updateFooterTotals();
        });
    </script>
  </body>
</html>
