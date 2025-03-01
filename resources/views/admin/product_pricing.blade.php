<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Products</title>
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
            <h2 class="h5 no-margin-bottom">Product / Product Pricing</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 mb-3 position-relative">
                                    <label>Product Name/Code</label>
                                    <input type="text" id="product-search_stock" name="product" class="form-control form-control-sm" placeholder="Search Product..." autocomplete="off">
                                    <input type="hidden" id="productID" name="productID">
                                    <div id="product-list_stock" class="list-group"></div>
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

                                <div class="col-lg-2 col-md-4 my-2">
                                    <button type="submit" id="product_stock_btn" class="btn btn-primary mt-md-3 px-4"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                </div>
                            </div>
                        </div>
                        <div class="block table-responsive" id="product_stock_div">
                            <table class="table table-hover" id="product_stock_table">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Product</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Expire Date</th>
                                        <th scope="col">Alert Date</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">Buying Price</th>
                                        <th scope="col">Selling Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="text-right"><button type="submit" id="stock_update_btn" class="btn btn-primary mt-3 px-4">Update</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    @include('admin.dash_script')

    <!-- JS For product search -->
    <script>
        $(document).ready(function () {
            let isScanning = false; // Flag to differentiate scanning from typing
            let lastAjaxRequest = null; // Store last AJAX request

            // Manual Typing Search
            $('#product-search_stock').on('keyup', function () {
                if (isScanning) return; // Prevent interference if barcode scan is in progress

                let query = $(this).val();
                if (query.length > 0) {
                    if (lastAjaxRequest) lastAjaxRequest.abort(); // Cancel previous request if exists

                    lastAjaxRequest = $.ajax({
                        url: "{{ route('search.products') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
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

            // Handle Selection from Suggestions
            $(document).on('click', '.list-group-item-action', function (e) {
                e.preventDefault();

                let productId = $(this).data('id');

                $('#product-search_stock').val($(this).text());
                $('#productID').val(productId);
                $('#product-list_stock').empty();
            });

            // Barcode Scanner Detection (Faster)
            $('#product-search_stock').scannerDetection({
                timeBeforeScanTest: 50, // Reduced for faster scan detection
                avgTimeByChar: 20, // Faster character processing
                onComplete: function (barcode) {
                    isScanning = true; // Set flag to prevent keyup interference

                    // Show scanned barcode instantly to prevent delay
                    $('#product-search_stock').val('Scanning...');

                    if (lastAjaxRequest) lastAjaxRequest.abort(); // Cancel any ongoing request

                    lastAjaxRequest = $.ajax({
                        url: "{{ route('search.products') }}",
                        type: "GET",
                        data: { query: barcode },
                        success: function (data) {
                            if (data.length > 0) {
                                let product = data[0]; // Auto-select first matched product
                                $('#product-search_stock').val(product.title);
                                $('#productID').val(product.id);
                            } else {
                                $('#product-search_stock').val('');
                                $('#productID').val('');
                                alert('No product found for this barcode!');
                            }
                            $('#product-list_stock').empty(); // Ensure suggestions are cleared
                            isScanning = false; // Reset flag
                        },
                        error: function () {
                            alert('Error searching for the scanned product.');
                            isScanning = false;
                        }
                    });
                }
            });
        });
    </script>
    <!-- JS For Table Row Append -->
    <script>
        $(document).ready(function () {
            const stocks = @json($stocks);
            const products = @json($products); // Add a JSON array for the products table

            function toggleBlock() {
                const hasRows = $('#product_stock_table tbody tr').length > 0;
                $('#product_stock_div').toggle(hasRows); // Show or hide the table based on rows
            }

            // Submit event to add rows for matching product batches
            $('#product_stock_btn').on('click', function () {
                // Get form values
                const productId = $('input[name="productID"]').val().trim();
                const category = $('select[name="category"]').val().trim();
                const subcategory = $('select[name="subcategory"]').val().trim();
                const brand = $('select[name="brand"]').val().trim();

                // Prevent submission if no input fields are filled
                if (!productId && !category && !subcategory && !brand) {
                    alert("Please fill at least one filter field.");
                    return; // Prevent further execution
                }

                // Find products that match the filters
                const filteredProducts = products.filter(product => {
                    return (
                        (!productId || product.id == productId) &&
                        (!category || product.category == category) &&
                        (!subcategory || product.sub_category == subcategory) &&
                        (!brand || product.brand == brand)
                    );
                });

                if (filteredProducts.length === 0) {
                    alert("No products found with the given filters.");
                    return;
                }

                // Find matching stocks for the filtered products
                const matchingStocks = stocks.filter(stock =>
                    filteredProducts.some(product => product.id == stock.product_id)
                );

                if (matchingStocks.length === 0) {
                    alert("No matching stock found for the given filters.");
                    return;
                }

                // Clear the previous rows from the table
                $('#product_stock_table tbody').empty();

                // Append rows for each matching stock
                matchingStocks.forEach(stock => {
                    // Get the associated product details for the stock
                    const product = products.find(p => p.id == stock.product_id);

                    $('#product_stock_table tbody').append(`
                        <tr>
                            <td>${product.title} ${product.barcode}</td>
                            <td>${stock.batch_no}</td>
                            <td>${product.category} / ${product.sub_category}</td>
                            <td>${product.brand}</td>
                            <td><input type="date" class="form-control form-control-sm exp-date-input" value="${stock.expiration_date}"></td>
                            <td><input type="date" class="form-control form-control-sm alt-date-input" value="${stock.alert_date}"></td>
                            <td>${stock.quantity}</td>
                            <td>${stock.purchase_price}</td>
                            <td><input type="number" class="form-control form-control-sm selling-price-input" value="${stock.sale_price}"></td>
                            <td class="d-none productID">${stock.product_id}</td>
                        </tr>
                    `);
                });

                // Reset the form fields manually
                $('input[name="productID"]').val('');
                $('input[name="product"]').val('');
                $('select[name="category"]').val('');
                $('select[name="subcategory"]').val('');
                $('select[name="brand"]').val('');

                // Show the table if it was hidden
                toggleBlock();
            });

            // Initial table visibility check
            toggleBlock();

            // Sending Data to the backend-------------->
            $('#stock_update_btn').on('click', function () {
                $('#stock_update_btn').prop('disabled', true);

                const rows = [];

                // Loop through each row in the table and collect row data
                $('#product_stock_table tbody tr').each(function () {
                    rows.push({
                        productId: $(this).find('.productID').text(),
                        batchNo: $(this).find('td:eq(1)').text(),
                        expDate: $(this).find('.exp-date-input').val(),
                        altDate: $(this).find('.alt-date-input').val(),
                        salePrice: parseFloat($(this).find('.selling-price-input').val()) || 0,
                    });
                });

                // Prepare the form data including stock_hidden data
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}'); // CSRF token for security
                formData.append('rows', JSON.stringify(rows));

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("update.stock") }}', // Laravel route URL
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
        });
    </script>
  </body>
</html>
