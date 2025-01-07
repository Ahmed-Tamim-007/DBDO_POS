<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <link rel="stylesheet" href="{{asset('admin_css/css/print.css')}}">
    <title>Admin - Daily-Monthly Summary</title>
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
            <h2 class="h5 no-margin-bottom">Reports / Daily-Monthly Summary</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block w-75 mx-auto">
                            <form action="{{ route('daily.summary.reports') }}" method="POST" id="daily_summary_form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">From Date</label>
                                        <input type="date" class="form-control form-control-sm" name="from_date">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">To Date</label>
                                        <input type="date" class="form-control form-control-sm" name="to_date">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <button type="submit" class="btn btn-primary mt-lg-4 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if ($sales_summary && $sale_returns_summary)
                        <div class="col-md-6">
                            <div class="block table-responsive">
                                <h3>Sales</h3>
                                <table class="table table-hover" id="sales_summary_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Paid (&#2547;)</th>
                                            <th scope="col">Due (&#2547;)</th>
                                            <th scope="col">Total (&#2547;)</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Sales</td>
                                            <td class="amt_td">{{$sales_summary->total_paid}}</td>
                                            <td class="amt_td">{{$sales_summary->total_due}}</td>
                                            <td class="amt_td">{{$sales_summary->total_amount}}</td>
                                            <td>
                                                <a href="{{ route('sales.entry.summary', ['fDate' => $fromDate, 'tDate' => $toDate]) }}" class="btn btn-outline-success btn-xs" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Sale Return</td>
                                            <td class="amt_td">{{$sale_returns_summary->total_amount}}</td>
                                            <td>0.00</td>
                                            <td class="amt_td">{{$sale_returns_summary->total_amount}}</td>
                                            <td>
                                                <a href="{{ route('sales.return.summary', ['fDate' => $fromDate, 'tDate' => $toDate]) }}" class="btn btn-outline-success btn-xs" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" colspan="2" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
                                            <th scope="col">0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if ($suppliers_summary)
                        <div class="col-md-6">
                            <div class="block table-responsive">
                                <h3>Supplier Payments</h3>
                                <table class="table table-hover" id="supplier_summary_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Total Amount (&#2547;)</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Advance</td>
                                            <td class="amt_td">{{$suppliers_summary->total_amount}}</td>
                                            <td>
                                                <a href="{{ route('supplier.trans.summary', ['fDate' => $fromDate, 'tDate' => $toDate]) }}" class="btn btn-outline-success btn-xs" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" colspan="2" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if ($office_expense_summary && $office_income_summary)
                        <div class="col-md-6">
                            <div class="block table-responsive">
                                <h3>Office Transactions</h3>
                                <table class="table table-hover" id="office_summary_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Total Amount (&#2547;)</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Expense</td>
                                            <td class="amt_td">{{$office_expense_summary->total_amount}}</td>
                                            <td>
                                                <a href="{{ route('office.expense.summary', ['fDate' => $fromDate, 'tDate' => $toDate]) }}" class="btn btn-outline-success btn-xs" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Income</td>
                                            <td class="amt_td">{{$office_income_summary->total_amount}}</td>
                                            <td>
                                                <a href="{{ route('office.income.summary', ['fDate' => $fromDate, 'tDate' => $toDate]) }}" class="btn btn-outline-success btn-xs" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" colspan="2" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if ($employee_payment_summary && $employee_return_summary)
                        <div class="col-md-6">
                            <div class="block table-responsive">
                                <h3>Employee Transactions</h3>
                                <table class="table table-hover" id="employee_summary_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Total Amount (&#2547;)</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Payment</td>
                                            <td class="amt_td">{{$employee_payment_summary->total_amount}}</td>
                                            <td>
                                                <a href="{{ route('employee.payment.summary', ['fDate' => $fromDate, 'tDate' => $toDate]) }}" class="btn btn-outline-success btn-xs" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Return</td>
                                            <td class="amt_td">{{$employee_return_summary->total_amount}}</td>
                                            <td>
                                                <a href="{{ route('employee.return.summary', ['fDate' => $fromDate, 'tDate' => $toDate]) }}" class="btn btn-outline-success btn-xs" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" colspan="2" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if ($employee_payment_summary)
                        <div class="col-md-6 mx-auto">
                            <div class="block table-responsive">
                                <h3>Total Summary Report</h3>
                                <table class="table table-hover" id="total_summary_table">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Total Balance (&#2547;)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Sales Transactions</td>
                                            <td class="amt_td"></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Supplier Transactions</td>
                                            <td class="amt_td"></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Office Transactions</td>
                                            <td class="amt_td"></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Employee Transactions</td>
                                            <td class="amt_td"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-primary">
                                            <th scope="col" colspan="2" class="text-right">Totals:</th>
                                            <th scope="col">0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    <!-- JavaScript files-->
    @include('admin.dash_script')

    <!-- Form Date Validation and else -->
    <script>
        $(document).ready(function () {
            // Validating the For before submitting
            $('#daily_summary_form').on('submit', function (e) {
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

            // Iterate over each element with the .amt_td class
            $('.amt_td').each(function () {
                // Check if the text is null, empty, or contains only whitespace
                if (!$(this).text().trim()) {
                    // Set the text to "0.00"
                    $(this).text('0.00');
                }
            });
        });
    </script>
    <!-- Updating Table Footer based on the table rows -->
    <script>
        $(document).ready(function () {
            // Footer uddation for sales table
            function updateSalesTableFooter() {
                let paidDiff = 0;
                let dueDiff = 0;
                let totalDiff = 0;

                // Get values from the first and second rows
                const $rows = $("#sales_summary_table tbody tr");

                if ($rows.length >= 2) {
                    const firstRow = $rows.eq(0);
                    const secondRow = $rows.eq(1);

                    // Parse values from the first row (Sales)
                    const paid1 = parseFloat(firstRow.find("td").eq(2).text()) || 0;
                    const due1 = parseFloat(firstRow.find("td").eq(3).text()) || 0;
                    const total1 = parseFloat(firstRow.find("td").eq(4).text()) || 0;

                    // Parse values from the second row (Sale Return)
                    const paid2 = parseFloat(secondRow.find("td").eq(2).text()) || 0;
                    const due2 = parseFloat(secondRow.find("td").eq(3).text()) || 0;
                    const total2 = parseFloat(secondRow.find("td").eq(4).text()) || 0;

                    // Calculate differences
                    paidDiff = paid1 - paid2;
                    dueDiff = due1 - due2;
                    totalDiff = total1 - total2;
                }

                // Update the footer with the calculated differences
                const $tfoot = $("#sales_summary_table tfoot tr");
                $tfoot.find("th").eq(1).text(paidDiff.toFixed(2)); // Paid difference
                $tfoot.find("th").eq(2).text(dueDiff.toFixed(2));  // Due difference
                $tfoot.find("th").eq(3).text(totalDiff.toFixed(2)); // Total difference
            }
            // Call the function on page load
            updateSalesTableFooter();
            // Re-calculate totals if the table data changes dynamically
            $(document).on("change", "#sales_summary_table tbody", function () {
                updateSalesTableFooter();
            });


            // Footer uddation for supplier table
            function updateSupplierTableFooter() {
                // Initialize variables
                let advance = 0;
                let otherAmount = 0; // Default for the absent second row

                // Get the advance amount from the first row
                $("#supplier_summary_table tbody tr").each(function (index) {
                    let amount = parseFloat($(this).find("td").eq(2).text()) || 0;
                    if (index === 0) { // Advance row (1st row)
                        advance = amount;
                    }
                });

                // Calculate the difference (Other Amount - Advance)
                let totalDifference = otherAmount - advance;

                // Update the footer with the calculated difference
                let $tfoot = $("#supplier_summary_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalDifference.toFixed(2));
            }
            // Call the function on page load
            updateSupplierTableFooter();
            // Optionally, re-calculate totals if the table data changes dynamically
            $(document).on("change", "#supplier_summary_table tbody", function () {
                updateSupplierTableFooter();
            });


            // Footer uddation for Office table
            function updateOfficeTableFooter() {
                // Initialize variables for expense and income
                let expense = 0;
                let income = 0;

                // Get the expense and income amounts from the respective rows
                $("#office_summary_table tbody tr").each(function (index) {
                    let amount = parseFloat($(this).find("td").eq(2).text()) || 0;
                    if (index === 0) { // Expense row (1st row)
                        expense = amount;
                    } else if (index === 1) { // Income row (2nd row)
                        income = amount;
                    }
                });

                // Calculate the difference (Income - Expense)
                let totalDifference = income - expense;

                // Update the footer with the calculated difference
                let $tfoot = $("#office_summary_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalDifference.toFixed(2));
            }
            // Call the function on page load
            updateOfficeTableFooter();
            // Optionally, re-calculate totals if the table data changes dynamically
            $(document).on("change", "#office_summary_table tbody", function () {
                updateOfficeTableFooter();
            });


            // Footer uddation for Employee table
            function updateEmployeeTableFooter() {
                // Initialize variables for payment and return amounts
                let payment = 0;
                let returnAmount = 0;

                // Get the payment and return amounts from the respective rows
                $("#employee_summary_table tbody tr").each(function (index) {
                    let amount = parseFloat($(this).find("td").eq(2).text()) || 0;
                    if (index === 0) { // Payment row (1st row)
                        payment = amount;
                    } else if (index === 1) { // Return row (2nd row)
                        returnAmount = amount;
                    }
                });

                // Calculate the difference (Return - Payment)
                let totalDifference = returnAmount - payment;

                // Update the footer with the calculated difference
                let $tfoot = $("#employee_summary_table tfoot tr");
                $tfoot.find("th").eq(1).text(totalDifference.toFixed(2));
            }
            // Call the function on page load
            updateEmployeeTableFooter();
            // Optionally, re-calculate totals if the table data changes dynamically
            $(document).on("change", "#employee_summary_table tbody", function () {
                updateEmployeeTableFooter();
            });


            // Footer updation for totals summary table
            function updateTotalSummaryTable() {
                let totalSummary = 0;

                // Map of row indexes to target table IDs and footer columns
                const tableMappings = [
                    { index: 0, tableId: "#sales_summary_table", footerColumn: 1 }, // Sales Transactions (Paid Total)
                    { index: 1, tableId: "#supplier_summary_table", footerColumn: 1 }, // Supplier Transactions (Total Amount)
                    { index: 2, tableId: "#office_summary_table", footerColumn: 1 }, // Office Transactions (Total Amount)
                    { index: 3, tableId: "#employee_summary_table", footerColumn: 1 }, // Employee Transactions (Total Difference)
                ];

                tableMappings.forEach(mapping => {
                    const tableFooterValue = parseFloat(
                        $(`${mapping.tableId} tfoot tr th`).eq(mapping.footerColumn).text()
                    ) || 0;

                    // Update the respective row in the total_summary_table
                    $("#total_summary_table tbody tr").eq(mapping.index).find("td").eq(2).text(tableFooterValue.toFixed(2));

                    // Accumulate total for the footer
                    totalSummary += tableFooterValue;
                });

                // Update the footer total
                $("#total_summary_table tfoot tr th").eq(1).text(totalSummary.toFixed(2));
            }

            // Call the function on page load
            updateTotalSummaryTable();

            // Recalculate totals dynamically when source tables are updated
            $(document).on("change", "#sales_summary_table, #supplier_summary_table, #office_summary_table, #employee_summary_table", function () {
                updateTotalSummaryTable();
            });

            // Trigger manually after dynamic updates, if any
            $(document).on("DOMSubtreeModified", "#sales_summary_table tfoot, #supplier_summary_table tfoot, #office_summary_table tfoot, #employee_summary_table tfoot", function () {
                updateTotalSummaryTable();
            });
        });
    </script>
  </body>
</html>
