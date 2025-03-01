<!DOCTYPE html>
<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.dash_head')
    <title>Admin - Stock Out</title>
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
                <h2 class="h5 no-margin-bottom">Stock / Stock Out</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="wrapper">
                        <div class="block">
                            <div class="text-right">
                                <a href="{{ url('stock_out_list') }}">
                                    <button type="button" class="btn btn-primary">Stock Out List</button>
                                </a>
                            </div>
                            <form id="stockout_out_append">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 mb-4 position-relative">
                                        <label>Product Name/Code</label>
                                        <input type="text" id="product-search_stock" name="product" class="form-control form-control-sm" required autocomplete="off">
                                        <div id="product-list_stock" class="list-group"></div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-4">
                                        <label>Batch Number</label>
                                        <select class="form-control form-control-sm form-select" name="batch_no" aria-label="Default select example" required>
                                            <option value="" selected>Select One</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-4">
                                        <label>Supplier</label>
                                        <input type="text" name="supplier" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="col-lg-1 col-md-3 mb-4">
                                        <label>Quantity</label>
                                        <input type="text" class="form-control form-control-sm" name="quantity" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-3 mb-4">
                                        <label>Expiration Date</label>
                                        <input type="date" class="form-control form-control-sm" name="exp_date" readonly>
                                    </div>
                                    <div class="col-lg-1 col-md-3 mb-4">
                                        <label>S.O. QTY</label>
                                        <input type="text" class="form-control form-control-sm" name="so_qty" required>
                                    </div>
                                    <div class="col-lg-1 col-md-3 mt-4">
                                        <button type="submit" class="btn btn-info w-100">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="block table-responsive">
                            <table id="stock_out_table" class="table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col" rowspan="2" style="display: none">ID</th>
                                        <th scope="col" rowspan="2">Product</th>
                                        <th scope="col" rowspan="2">Supplier</th>
                                        <th scope="col" rowspan="2">Quantity</th>
                                        <th scope="col" colspan="2" class="text-center">Price (&#2547;)</th>
                                        <th scope="col" rowspan="2">Rack ID</th>
                                        <th scope="col" rowspan="2">Expiration Date</th>
                                        <th scope="col" rowspan="2">Batch</th>
                                        <th scope="col" rowspan="2">S.O. Qty</th>
                                    </tr>
                                    <tr class="text-primary">
                                        <th scope="col">Purchase</th>
                                        <th scope="col">Sale</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="block" id="stock_out_hidden" style="display: none;">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <label class="">Stock Out Date</label>
                                    <input type="date" class="form-control form-control-sm" id="stock_date" required>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label>Stock Out Doc</label>
                                    <input type="file" class="form-control form-control-sm" id="image" name="image">
                                    <p class="text-primary text-bold" style="font-size: 12px">Use jpg,jpeg,png,gif only.</p>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-4">
                                    <label class="">Invoice No</label>
                                    <input type="text" class="form-control form-control-sm" id="stock_invoice" required>
                                </div>
                                <div class="col-lg-4 col-md-8 mb-4">
                                    <label class="">Stock Out Note</label>
                                    <textarea class="form-control form-control-sm" id="stock_note" rows="1"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" id="save-stock-out" class="btn btn-primary">Save Stock</button>
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

                $('#product-search_stock').val($(this).text());
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
                            } else {
                                $('#product-search_stock').val('');
                                alert('No product found for this barcode!');
                            }
                            $('#product-list_stock').empty(); // Ensure suggestions are cleared
                            $('#product-list_stock').focusout();
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

    <!-- JS For Getting batch_no and ETC. -->
    <script>
        $(document).ready(function () {
            const stocks = @json($stocks);

            // Getting the batch no based on the product name
            $('#product-list_stock').on('focusout', function () {
                let productName = $("#product-search_stock").val().trim().toLowerCase();

                if (productName) {
                    $('select[name="batch_no"]').html('<option value="" selected>Loading...</option>');

                    // Filter stocks for matching product name
                    let matchingBatches = stocks.filter(stock =>
                        stock.product_name.trim().toLowerCase() === productName
                    );

                    if (matchingBatches.length > 0) {
                        let options = '<option value="" selected>Select One</option>';
                        matchingBatches.forEach(function (batch) {
                            options += `<option value="${batch.id}">${batch.batch_no}</option>`;
                        });
                        $('select[name="batch_no"]').html(options);
                    } else {
                        $('select[name="batch_no"]').html('<option value="" selected>Select One</option>');
                        alert('No batches found for the entered product.');
                    }
                    // setTimeout(function () {
                    // }, 100);
                } else {
                    $('select[name="batch_no"]').html('<option value="" selected>Select One</option>');
                }
            });

            // When a batch is selected
            $('select[name="batch_no"]').on('change', function () {
                let batchId = $(this).val();
                if (batchId) {
                    let selectedBatch = stocks.find(stock => stock.id == batchId);
                    if (selectedBatch) {
                        $('input[name="supplier"]').val(selectedBatch.supplier || '');
                        $('input[name="quantity"]').val(selectedBatch.quantity || '');
                        $('input[name="exp_date"]').val(selectedBatch.expiration_date || '');
                    }
                } else {
                    $('input[name="supplier"]').val('');
                    $('input[name="quantity"]').val('');
                    $('input[name="exp_date"]').val('');
                }
            });

            // Check if S.O. QTY exceeds Quantity or contains invalid input
            $('input[name="so_qty"]').on('input', function () {
                let soQty = $(this).val().trim();
                let quantity = parseFloat($('input[name="quantity"]').val().trim());

                // Check for invalid input (non-decimal number)
                if (!/^\d*\.?\d*$/.test(soQty)) {
                    alert('Please enter a valid decimal number.');
                    $(this).val(''); // Reset the field
                    return; // Exit further checks
                }

                // Convert to number for comparison
                soQty = parseFloat(soQty);

                // Check if S.O. QTY exceeds Quantity
                if (soQty > quantity) {
                    alert('S.O. QTY cannot exceed available Quantity.');
                    $(this).val(''); // Reset the field
                }
            });
        });
    </script>

    <!-- JS For Table Row Append -->
    <script>
        $(document).ready(function () {
            const stocks = @json($stocks);

            function toggleForm() {
                const hasRows = $('#stock_out_table tbody tr').length > 0;
                $('#stock_out_hidden').toggle(hasRows); // Show or hide the form based on rows
            }

            // Submit event to add a new row
            $('#stockout_out_append').on('submit', function (e) {
                e.preventDefault();

                // Get form values
                const productName = $('input[name="product"]').val().trim();
                const supplier = $('input[name="supplier"]').val().trim();
                const quantity = parseFloat($('input[name="quantity"]').val().trim()) || 0;
                const expDate = $('input[name="exp_date"]').val();
                const batch = $('select[name="batch_no"] option:selected').text();
                const so_qty = $('input[name="so_qty"]').val();

                // Find the product in stocks array
                const stock = stocks.find(p => p.product_name === productName);

                if (!stock) {
                    alert("Product not found.");
                    return;
                }

                // Append a new row to the table with editable inputs and a Remove button
                $('#stock_out_table tbody').append(`
                    <tr>
                        <td style="display: none">${stock.product_id}</td>
                        <td>${stock.product_name}</td>
                        <td>${supplier}</td>
                        <td><input type="number" class="form-control form-control-sm qty-input" value="${quantity}" readonly></td>
                        <td><input type="number" class="form-control form-control-sm price-input" value="${stock.purchase_price}" readonly></td>
                        <td><input type="number" class="form-control form-control-sm sale-input" value="${stock.sale_price}" readonly></td>
                        <td>${stock.rack_id}</td>
                        <td>${expDate}</td>
                        <td>${batch}</td>
                        <td><input type="number" class="form-control form-control-sm so-qty-input" value="${so_qty}"></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-times"></i></button></td>
                    </tr>
                `);

                // Reset the form fields and update the totals
                this.reset();
                toggleForm();
            });

            // Event delegation for the Remove button
            $('#stock_out_table').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                updateTotals(); // Update totals after row removal
                toggleForm();   // Toggle form visibility
            });

            // Validate that .so-qty-input does not exceed .qty-input
            $('#stock_out_table').on('input', '.so-qty-input', function () {
                const soQtyInput = $(this);
                const soQty = parseFloat(soQtyInput.val().trim()) || 0;
                const qtyInput = parseFloat(soQtyInput.closest('tr').find('.qty-input').val().trim()) || 0;

                if (soQty > qtyInput) {
                    alert('S.O. QTY cannot exceed the available Quantity.');
                    soQtyInput.val(''); // Clear the input if the value exceeds the limit
                }
            });

            // Initial form visibility check
            toggleForm();

            // Set the default value of #stock_date to the current date
            const today = new Date().toISOString().split('T')[0];
            $('#stock_date').val(today);

            // Fetch the next stock invoice number on page load
            $.ajax({
                url: '{{ route("get.next.stock.out.invoice") }}',
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

            // Sending Data to the functions-------------->
            $('#save-stock-out').on('click', function () {
                const stockDate = $('#stock_date').val().trim();
                const stockInvoice = $('#stock_invoice').val().trim();

                // Validate required fields
                if (!stockDate || !stockInvoice) {
                    alert('Please fill out both the Stock Out Date and Invoice No fields before saving.');
                    return; // Stop execution here
                }

                const rows = [];

                // Collect the stock_out_hidden data
                const imageFile = $('#image')[0].files[0]; // Getting the selected file
                const stockNote = $('#stock_note').val().trim();

                // Loop through each row in the table and collect row data
                $('#stock_out_table tbody tr').each(function () {
                    rows.push({
                        product_id: $(this).find('td:eq(0)').text(),
                        product_name: $(this).find('td:eq(1)').text(),
                        supplier: $(this).find('td:eq(2)').text(),
                        quantity: parseFloat($(this).find('.qty-input').val()) || 0,
                        purchase_price: parseFloat($(this).find('.price-input').val()) || 0,
                        sale_price: parseFloat($(this).find('.sale-input').val()) || 0,
                        rack_id: $(this).find('td:eq(6)').text(),
                        expiration_date: $(this).find('td:eq(4)').text().trim() ? $(this).find('td:eq(7)').text() : null,
                        batch_no: $(this).find('td:eq(8)').text(),
                        so_qty: parseFloat($(this).find('.so-qty-input').val()) || 0,
                    });
                });

                // Prepare the form data including stock_out_hidden data
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('stock_date', stockDate);
                formData.append('image', imageFile);
                formData.append('stock_invoice', stockInvoice);
                formData.append('stock_note', stockNote);
                formData.append('rows', JSON.stringify(rows));

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("save.stock.out") }}',
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
