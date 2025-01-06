<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>Admin - Stock Report</title>
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
            <h2 class="h5 no-margin-bottom">Reports / Stock Report</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('search.stock.report') }}" method="POST" id="stock_report_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 mb-3 position-relative">
                                        <label>Product Name/Code</label>
                                        <input type="text" id="product-search_stock" name="product" class="form-control form-control-sm" placeholder="Search Product..." autocomplete="off">
                                        <input type="hidden" id="productID" name="productID">
                                        <div id="product-list_stock" class="list-group"></div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
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
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Sub Category</label>
                                        <select class="form-control form-control-sm form-select" name="subcategory" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{$subcategory->sub_category}}">{{$subcategory->sub_category}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Brand</label>
                                        <select class="form-control form-control-sm form-select" name="brand" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($brands as $brand)
                                                <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3 position-relative">
                                        <label class="form-label">Suppliers</label>
                                        <input type="text" id="supplier_search" name="supplier" class="form-control form-control-sm" autocomplete="off" placeholder="Search Supplier...">
                                        <input type="hidden" name="supplierID" id="supplierID">
                                        <div id="supplier_search_list" class="list-group" style="width: 90%;"></div>
                                    </div>

                                    <div class="col-lg-2 col-md-4 my-2">
                                        <button type="submit" class="btn btn-primary mt-lg-3 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($stocks->isNotEmpty())
                            <div class="block table-responsive">
                                <h5 class="text-center">Stocks From: {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} &nbsp;- To: {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</h5>
                                <table class="table table-hover" id="stock_report_table" style="border-bottom: 1px solid #019bee;">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">Product Code</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Category/Subcategory</th>
                                            <th scope="col">Supplier</th>
                                            <th scope="col">Batch Number</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Purchase Price</th>
                                            <th scope="col">Selling Price</th>
                                            <th scope="col">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $stock)
                                            <tr>
                                                <td>{{$stock->product_code}}</td>
                                                <td>{{$stock->product_name}}</td>
                                                <td>{{$stock->product_cat}}/{{$stock->product_sub_cat}}</td>
                                                <td>{{$stock->supplier}}</td>
                                                <td>{{$stock->batch_no}}</td>
                                                <td>{{$stock->quantity}}</td>
                                                <td>{{$stock->purchase_price}}</td>
                                                <td>{{$stock->sale_price}}</td>
                                                <td>{{ number_format($stock->purchase_price * $stock->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row mt-2 text-primary">
                                    <div class="col-md-4">Total:</div>
                                    <div class="col-md-4 text-right">
                                        Total Qty: <span id="t_qty">0.00</span><br>
                                        Total Item: <span id="t_item">0.00</span>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        Stock Value: <span id="stock_val">0.00</span><br>
                                        Est. Selling Price: <span id="est_price">0.00</span>
                                    </div>
                                </div>
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

    <!-- Form Validation -->
    <script>
        $(document).ready(function () {
            $('#stock_report_form').on('submit', function (e) {
                let isValid = false;

                // Check all input and select fields
                $(this).find('input[type="text"], input[type="number"], select').each(function () {
                    if ($(this).val().trim() !== '') {
                        isValid = true;
                        return false; // Exit the loop early if a value is found
                    }
                });

                if (!isValid) {
                    e.preventDefault(); // Prevent form submission
                    alert('Please fill in at least one field before submitting.');
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
