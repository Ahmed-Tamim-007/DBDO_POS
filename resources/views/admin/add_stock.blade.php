<!DOCTYPE html>
<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.dash_head')
    <title>Admin - Add Stock</title>
    <style>
        .table thead tr:first-child {
            border-bottom: 1px solid rgba(0, 0, 0, 0.3); /* Adjust color and thickness as needed */
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
                <h2 class="h5 no-margin-bottom">Stock / Add Stock</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="wrapper">
                        <div class="block">
                            <div class="text-right">
                                <a href="{{ url('stock_in_list') }}">
                                    <button type="button" class="btn btn-primary">Stock List</button>
                                </a>
                            </div>
                            <form action="" id="stock_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 mb-4 position-relative">
                                        <label>Product Name/Code</label>
                                        <input type="text" id="product-search_stock" name="product" class="form-control form-control-sm" required autocomplete="off">
                                        <div id="product-list_stock" class="list-group"></div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <label>Supplier</label>
                                        <input type="text" name="supplier" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-lg-1 col-md-2 mb-4">
                                        <label>Quantity</label>
                                        <input type="text" class="form-control form-control-sm" name="quantity" required>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-4">
                                        <label>Expiration Date</label>
                                        <input type="date" class="form-control form-control-sm" name="exp_date">
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-4">
                                        <label>Alert Date</label>
                                        <input type="date" class="form-control form-control-sm" name="alt_date">
                                    </div>
                                    <div class="col-lg-1 col-md-2 mt-4">
                                        <button type="submit" class="btn btn-info w-100">Add</button>
                                    </div>
                                </div>
                            </form>
                            {{-- <hr class="" style="border: 0.5px solid rgba(0, 0, 0, 0.1);"> --}}
                        </div>
                        <div class="block table-responsive">
                            <table id="stock_table" class="table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col" rowspan="2">SL.</th>
                                        <th scope="col" rowspan="2">Product</th>
                                        <th scope="col" rowspan="2">Supplier</th>
                                        <th scope="col" rowspan="2">Rack ID</th>
                                        <th scope="col" rowspan="2">Expiration Date</th>
                                        <th scope="col" rowspan="2">QTY</th>
                                        <th scope="col" colspan="2" class="text-center">Price (&#2547;)</th>
                                        <th scope="col" colspan="2" class="text-center">Total (&#2547;)</th>
                                    </tr>
                                    <tr class="text-primary">
                                        <th scope="col">Purchase</th>
                                        <th scope="col">Sale</th>
                                        <th scope="col">Purchase</th>
                                        <th scope="col">Sale</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr class="text-primary">
                                        <th scope="col" colspan="5" class="text-right">Total:</th>
                                        <th id="t_qty" scope="col">0</th>
                                        <th id="t_price_purchase" scope="col">0.00</th>
                                        <th id="t_price_sale" scope="col">0.00</th>
                                        <th id="t_total_purchase" scope="col">0.00</th>
                                        <th id="t_total_sale" scope="col">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="block" id="stock_hidden" style="display: none;">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <label class="">Stock In Date</label>
                                    <input type="date" class="form-control form-control-sm" id="stock_date" required>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label>Stock In Doc</label>
                                    <input type="file" class="form-control form-control-sm" id="image" name="image">
                                    <p class="text-primary text-bold" style="font-size: 12px">Use jpg,jpeg,png,gif only.</p>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-4">
                                    <label class="">Invoice No</label>
                                    <input type="text" class="form-control form-control-sm" id="stock_invoice" required>
                                </div>
                                <div class="col-lg-4 col-md-8 mb-4">
                                    <label class="">Stock In Note</label>
                                    <textarea class="form-control form-control-sm" id="stock_note" rows="1"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" id="save-stock" class="btn btn-primary">Save Stock</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    <!-- JS Files -->
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
        const products = @json($products);
    </script>
    <script>
        $(document).ready(function () {
            // Set the default value of #stock_date to the current date
            const today = new Date().toISOString().split('T')[0];
            $('#stock_date').val(today);


            // Fetch the next stock invoice number on page load
            $.ajax({
                url: '{{ route("get.next.stock.invoice") }}', // Laravel route URL
                type: 'GET',
                success: function (response) {
                    if (response.next_invoice) {
                        $('#stock_invoice').val(response.next_invoice); // Set the value in the input field
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching the next stock invoice:', xhr.responseText);
                }
            });

            function updateTotals() {
                let totalQuantity = 0;
                let totalPricePurchase = 0;
                let totalPriceSale = 0;
                let totalPurchase = 0;
                let totalSale = 0;

                // Iterate through each row in the tbody
                $('#stock_table tbody tr').each(function () {
                    const quantity = parseFloat($(this).find('.qty-input').val()) || 0;
                    const purchasePrice = parseFloat($(this).find('.price-input').val()) || 0;
                    const salePrice = parseFloat($(this).find('.sale-input').val()) || 0;

                    totalQuantity += quantity;
                    totalPricePurchase += purchasePrice;
                    totalPriceSale += salePrice;
                    totalPurchase += purchasePrice * quantity;
                    totalSale += salePrice * quantity;
                });

                // Update the footer totals
                $('#t_qty').text(totalQuantity);
                $('#t_price_purchase').html(`${totalPricePurchase.toFixed(2)}`);
                $('#t_price_sale').html(`${totalPriceSale.toFixed(2)}`);
                $('#t_total_purchase').html(`${totalPurchase.toFixed(2)}`);
                $('#t_total_sale').html(`${totalSale.toFixed(2)}`);
            }

            function toggleForm() {
                const hasRows = $('#stock_table tbody tr').length > 0;
                $('#stock_hidden').toggle(hasRows); // Show or hide the form based on rows
            }

            // Submit event to add a new row
            $('#stock_form').on('submit', function (e) {
                e.preventDefault();

                // Get form values
                const productName = $('input[name="product"]').val().trim();
                const supplier = $('input[name="supplier"]').val().trim();
                const quantity = parseFloat($('input[name="quantity"]').val().trim()) || 0;
                const expDate = $('input[name="exp_date"]').val();
                const altDate = $('input[name="alt_date"]').val();

                // Find the product in products array
                const product = products.find(p => p.title === productName);

                if (!product) {
                    alert("Product not found.");
                    return;
                }

                // Calculate initial totals
                const totalPurchase = (product.b_price * quantity).toFixed(2);
                const totalSale = (product.s_price * quantity).toFixed(2);

                // Append a new row to the table with editable inputs and a Remove button
                $('#stock_table tbody').append(`
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.title}</td>
                        <td>${supplier}</td>
                        <td>N/A</td>
                        <td>${expDate}</td>
                        <td style="display: none;">${altDate}</td>
                        <td><input type="number" class="form-control form-control-sm qty-input" value="${quantity}"></td>
                        <td><input type="number" class="form-control form-control-sm price-input" value="${product.b_price}"></td>
                        <td><input type="number" class="form-control form-control-sm sale-input" value="${product.s_price}"></td>
                        <td class="total-purchase">${totalPurchase}</td>
                        <td class="total-sale">${totalSale}</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-times"></i></button></td>
                    </tr>
                `);

                // Reset the form fields and update the totals
                this.reset();
                updateTotals();
                toggleForm();
            });

            // Event delegation for updating totals on input change
            $('#stock_table').on('input', '.qty-input, .price-input, .sale-input', function () {
                const row = $(this).closest('tr');
                const quantity = parseFloat(row.find('.qty-input').val()) || 0;
                const purchasePrice = parseFloat(row.find('.price-input').val()) || 0;
                const salePrice = parseFloat(row.find('.sale-input').val()) || 0;

                // Recalculate totals for the row
                const newTotalPurchase = (purchasePrice * quantity).toFixed(2);
                const newTotalSale = (salePrice * quantity).toFixed(2);

                // Update row totals
                row.find('.total-purchase').html(`${newTotalPurchase}`);
                row.find('.total-sale').html(`${newTotalSale}`);

                // Update footer totals
                updateTotals();
            });

            // Event delegation for the Remove button
            $('#stock_table').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                updateTotals(); // Update totals after row removal
                toggleForm();   // Toggle form visibility
            });

            // Initial form visibility check
            toggleForm();


            // Sending Data to the functions-------------->
            $('#save-stock').on('click', function () {
                const stockDate = $('#stock_date').val().trim();
                const stockInvoice = $('#stock_invoice').val().trim();

                // Validate required fields
                if (!stockDate || !stockInvoice) {
                    alert('Please fill out both the Stock In Date and Invoice No fields before saving.');
                    return; // Stop execution here
                }

                const rows = [];

                // Collect the stock_hidden data
                const imageFile = $('#image')[0].files[0]; // Getting the selected file
                const stockNote = $('#stock_note').val().trim();

                // Loop through each row in the table and collect row data
                $('#stock_table tbody tr').each(function () {
                    rows.push({
                        product_id: $(this).find('td:eq(0)').text(),
                        product_name: $(this).find('td:eq(1)').text(),
                        supplier: $(this).find('td:eq(2)').text(),
                        rackID: $(this).find('td:eq(3)').text().trim() ? $(this).find('td:eq(3)').text() : 'N/A',
                        quantity: parseFloat($(this).find('.qty-input').val()) || 0,
                        expiration_date: $(this).find('td:eq(4)').text().trim() ? $(this).find('td:eq(4)').text() : null,
                        alert_date: $(this).find('td:eq(5)').text().trim() ? $(this).find('td:eq(5)').text() : null,
                        purchase_price: parseFloat($(this).find('.price-input').val()) || 0,
                        sale_price: parseFloat($(this).find('.sale-input').val()) || 0,
                    });
                });

                // Prepare the form data including stock_hidden data
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}'); // CSRF token for security
                formData.append('stock_date', stockDate);
                formData.append('image', imageFile);  // Append the file for the image
                formData.append('stock_invoice', stockInvoice);
                formData.append('stock_note', stockNote);
                formData.append('rows', JSON.stringify(rows));  // Convert rows array to string for backend

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("save.stock") }}', // Laravel route URL
                    type: 'POST',
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting the content type
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
