<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Products</title>
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
                <h2 class="h5 no-margin-bottom">Product / Bulk Barcode</h2>
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

                                <div class="col-lg-2 col-md-4 my-2">
                                    <button type="submit" id="product_add_btn" class="btn btn-primary mt-md-3"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="block table-responsive" id="product_div">
                            <table class="table table-hover" id="product_table">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Barcode</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Price(&#2547;)</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#barcode_print_modal" class="btn btn-primary mt-3">Preview Barcode</button>
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

    <!-- Print Barcode Modal -->
    <div id="barcode_print_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg" id="printModal">
            <div class="modal-content">
                <div class="modal-header">
                    <strong id="exampleModalLabel" class="modal-title">Bulk Barcode Preview</strong>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Barcode items will be appended here -->
                </div>
                <div class="modal-footer" id="modal_footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                    <input type="submit" class="btn btn-primary" id="print_btn" value="Print">
                </div>
            </div>
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
            const products = @json($productsWithBarcodes);

            function toggleBlock() {
                const hasRows = $('#product_table tbody tr').length > 0;
                $('#product_div').toggle(hasRows); // Show or hide the table based on rows
            }

            // Submit event to add rows for matching product batches
            $('#product_add_btn').on('click', function () {
                const productId = $('input[name="productID"]').val().trim();

                if (!productId) {
                    alert("Please select a product!");
                    return;
                }

                const filteredProducts = products.filter(product => {
                    return (!productId || product.id == productId);
                });

                if (filteredProducts.length === 0) {
                    alert("No products found with the given filters.");
                    return;
                }

                filteredProducts.forEach(product => {
                    // Add the product directly without checking if it already exists
                    $('#product_table tbody').append(`
                        <tr data-product-id="${product.id}"> <!-- Store product ID in the data attribute -->
                            <td>${product.title}</td>
                            <td>${product.barcode_html} ${product.barcode}</td>
                            <td>${product.category} / ${product.sub_category}</td>
                            <td>${product.brand}</td>
                            <td>${product.s_price}</td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-times"></i></button></td>
                        </tr>
                    `);
                });

                $('input[name="productID"]').val('');
                $('input[name="product"]').val('');
                toggleBlock();
            });

            $('#product_table').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                toggleBlock();
            });

            // Show barcodes in modal
            $('#barcode_print_modal').on('show.bs.modal', function () {
                // Clear the modal body content
                const modalBody = $(this).find('.modal-body');
                modalBody.html('');

                // Create a container to hold all barcode items inline
                const container = $('<div>').addClass('barcode-container').css({
                    'display': 'inline-flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'center',
                });

                // Loop through the products in the table and generate barcodes
                $('#product_table tbody tr').each(function () {
                    const productTitle = $(this).find('td').eq(0).text();
                    const barcodeHTML = $(this).find('td').eq(1).html(); // Get barcode HTML

                    // Create a box for each barcode item
                    const box = $('<div>').addClass('barcode-item').css({
                        'border': '1px solid #ddd',
                        'padding': '15px',
                        'width': '250px', // Adjust width for the box
                        'text-align': 'center',
                        'display': 'ruby',
                        'box-shadow': '0 2px 5px rgba(0,0,0,0.1)',
                        'border-radius': '8px',
                    });

                    // Append the content to the box
                    box.append(`
                        <h5>${productTitle}</h5>
                        ${barcodeHTML}
                    `);

                    // Append the box to the container
                    container.append(box);
                });

                // Append the container to the modal body
                modalBody.append(container);
            });
            $('#print_btn').on('click', function () {
                alert('Coming Soon!');
            });

            // Initial table visibility check
            toggleBlock();
        });
    </script>

  </body>
</html>
