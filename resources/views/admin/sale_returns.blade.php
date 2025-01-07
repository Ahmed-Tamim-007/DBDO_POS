<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Sale Returns</title>
    <style>
        #salesInfoTable td {
            padding: 1px 2px !important;
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
                <h2 class="h5 no-margin-bottom">Sales / Sale Returns</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="block">
                            <div class="form-group m-0" id="invoice_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="invoice_search_input" placeholder="Search Invoice No...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" id="invoice_search_btn"><i class="icon-magnifying-glass-browser"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <table class="table table-hover" id="return_table">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Check</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Returned</th>
                                        <th scope="col" style="width: 140px;">Return Qty</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col" class="d-none">Product ID</th>
                                        <th scope="col" class="d-none">Sale ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-3 ml-auto">
                                    <table class="table mt-3" id="salesInfoTable" style="font-size: 12px;">
                                        <tbody>
                                            <tr>
                                                <td>Card Total</td>
                                                <td class="text-right" id="card_total"></td>
                                            </tr>
                                            <tr>
                                                <td>Discount</td>
                                                <td class="text-right" id="sale_dis"></td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td class="text-right" id="sale_total"></td>
                                            </tr>
                                            <tr>
                                                <td>Round</td>
                                                <td class="text-right" id="sale_round"></td>
                                            </tr>
                                            <tr>
                                                <td>Paid Amount</td>
                                                <td class="text-right" id="paid_amt"></td>
                                            </tr>
                                            <tr>
                                                <td>Total Due</td>
                                                <td class="text-right" id="sale_due"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div>
                                <button type="button" id="addToreturn" class="btn btn-primary btn-sm mt-3">Add Return</button>
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

    <!-- All JS Files -->
    @include('admin.dash_script')

    <!-- JS For Sale Returns -->
    <script>
        $(document).ready(function() {
            const sale_details = @json($sale_details);
            const sales = @json($sales);

            // Function to handle the search logic
            function searchInvoice() {
                const saleInvoice = $('#invoice_search_input').val().trim();

                // Find the matching sale detail
                const saleDetail = sale_details.find(p => p.invoiceNo === saleInvoice);

                if (!saleDetail) {
                    alert("Invoice not found.");
                    return;
                }

                // Find all sales related to this sale detail
                const relatedSales = sales.filter(sale => sale.sales_ID === saleDetail.id);

                if (relatedSales.length === 0) {
                    alert("No sales found for this invoice.");
                    return;
                }

                // Clear the previous rows
                $('#return_table tbody').empty();

                // Append rows for each related sale
                relatedSales.forEach(sale => {
                    $('#return_table tbody').append(`
                        <tr>
                            <td class="td-check">
                                <label class="custom-checkbox">
                                    <input type="checkbox" value="">
                                    <span></span>
                                </label>
                            </td>
                            <td>${sale.product_name}</td>
                            <td>${sale.batch_no}</td>
                            <td>${sale.so_qty}</td>
                            <td>${sale.returned || 0}</td>
                            <td><input type="number" class="form-control form-control-sm return_qty" min="0"></td>
                            <td>${sale.price}</td>
                            <td>${sale.total}</td>
                            <td class="d-none">${sale.product_id}</td>
                            <td class="d-none">${sale.sales_ID}</td>
                        </tr>
                    `);
                });

                let cardTotal = 0;
                if (saleDetail) {
                    $("#return_table tbody tr").each(function () {
                        cardTotal += parseFloat($(this).find("td").eq(7).text()) || 0;
                    });
                    let saleTotal = parseFloat(saleDetail.cashTotal) || 0;
                    let saleDiscount = saleDetail.cashDiscount;
                    let saleRound = parseFloat(saleDetail.cashRound) || 0;
                    let paidTotal = parseFloat(saleDetail.cashAmount + saleDetail.cardAmount + saleDetail.mobileAmount) || 0;
                    let saleDue = parseFloat(saleDetail.cashDue) || 0;

                    // Update table total quantity and price
                    $('#salesInfoTable #card_total').text(cardTotal.toFixed(2));
                    $('#salesInfoTable #sale_dis').text(saleDiscount);
                    $('#salesInfoTable #sale_total').text(saleTotal.toFixed(2));
                    $('#salesInfoTable #sale_round').text(saleRound.toFixed(2));
                    $('#salesInfoTable #paid_amt').text(paidTotal.toFixed(2));
                    $('#salesInfoTable #sale_due').text(saleDue.toFixed(2));
                }

                // Update the visibility of the return button
                toggleReturn();
            }

            // Function to toggle the visibility of the return button
            function toggleReturn() {
                const hasRows = $('#return_table tbody tr').length > 0;
                $('#addToreturn').toggle(hasRows); // Show or hide the button based on rows
                $('#salesInfoTable').toggle(hasRows); // Show or hide the button based on rows
            }

            // Function to handle the add to return button logic
            function handleAddToReturn() {
                // Get all checked rows
                const checkedRows = $('#return_table tbody tr').filter(function () {
                    return $(this).find('input[type="checkbox"]').is(':checked');
                });

                // If no rows are checked, show an alert and return
                if (checkedRows.length === 0) {
                    alert('Please select an item first');
                    return;
                }

                // Create the second table if it doesn't exist
                if ($('#appended_table').length === 0) {
                    const appendedTableHtml = `
                        <div class="table-responsive mt-4">
                            <table class="table table-hover" id="appended_table">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Return Qty</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col" class="d-none">Product ID</th>
                                        <th scope="col" class="d-none">Sale ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div>
                                <button type="button" id="return_btn" class="btn btn-primary btn-sm mt-3">Return</button>
                            </div>
                        </div>
                    `;

                    // Append the table after the #addToreturn button
                    $('#addToreturn').after(appendedTableHtml);
                }

                // Clear previous appended rows in the second table
                $('#appended_table tbody').empty();

                // Append checked rows to the second table
                checkedRows.each(function () {
                    const row = $(this);
                    const productName = row.find('td').eq(1).text();
                    const batch = row.find('td').eq(2).text();
                    const quantity = parseFloat(row.find('td').eq(3).text()).toFixed(2);
                    const returned = parseFloat(row.find('td').eq(4).text()).toFixed(2);
                    const returnQty = parseFloat(row.find('td').eq(5).find('input').val()).toFixed(2);
                    const unitPrice = row.find('td').eq(6).text();
                    const totalPrice = row.find('td').eq(7).text();
                    const productID = row.find('td').eq(8).text();
                    const saleID = row.find('td').eq(9).text();

                    // Check if Return Qty is empty or not a number
                    if (!returnQty || isNaN(returnQty)) {
                        alert(`Return quantity for ${productName} is empty. Please enter a valid quantity.`);
                        return; // Skip this row
                    }

                    // Check if the item is completely returned
                    if (quantity === returned) {
                        alert(`This item (${productName}) is completely returned.`);
                        return; // Skip this row
                    }

                    // Check if the return quantity exceeds the available quantity
                    if (returnQty > (quantity - returned)) {
                        alert(`Return quantity for ${productName} exceeds the available quantity.`);
                        return; // Skip this row
                    }

                    // Append to the appended table
                    $('#appended_table tbody').append(`
                        <tr>
                            <td>${productName}</td>
                            <td>${batch}</td>
                            <td>${returnQty}</td>
                            <td>${unitPrice}</td>
                            <td>${totalPrice}</td>
                            <td class="d-none">${productID}</td>
                            <td class="d-none">${saleID}</td>
                        </tr>
                    `);
                });

                // Uncheck the checkboxes in the original table after moving rows
                $('#return_table tbody input[type="checkbox"]').prop('checked', false);

                // Toggle the visibility of the addToReturn button
                toggleReturn();
            }

            // Attach the click event to the add to return button
            $('#addToreturn').on('click', function () {
                handleAddToReturn();
            });

            // Attach event to the dynamically appended "Return" button
            $(document).on('click', '#return_btn', function () {

                let invoice_no = Date.now();

                const rows = [];
                // Loop through each row in the table and collect row data
                $('#appended_table tbody tr').each(function () {
                    rows.push({
                        product_name: $(this).find('td:eq(0)').text(),
                        batch: $(this).find('td:eq(1)').text(),
                        return_qty: $(this).find('td:eq(2)').text(),
                        price: $(this).find('td:eq(3)').text(),
                        total_price: $(this).find('td:eq(4)').text(),
                        product_id: $(this).find('td:eq(5)').text(),
                        sales_ID: $(this).find('td:eq(6)').text(),
                    });
                });

                // Prepare the form data including stock_hidden data
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('invoice_no', invoice_no);
                formData.append('rows', JSON.stringify(rows));  // Convert rows array to string for backend

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("save.return") }}',
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

            // Click event for the search button
            $('#invoice_search_btn').on('click', function () {
                searchInvoice();
            });

            // Keydown event for the input field
            $('#invoice_search_input').on('keydown', function (event) {
                if (event.key === "Enter" || event.keyCode === 13) {
                    event.preventDefault();
                    searchInvoice();
                }
            });

            // Initial check for the return button visibility on page load
            $(document).ready(function () {
                toggleReturn();
            });
        });
    </script>
  </body>
</html>
