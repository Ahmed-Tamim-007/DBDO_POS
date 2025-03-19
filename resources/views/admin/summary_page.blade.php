<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Summary Report</title>
    <style>
        table th, td {
            padding: 8px;
        }
        body {
            color: black !important;
        }
    </style>
  </head>
  <body>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto my-4">
                    <div class="row mt-5 mb-3 font-weight-bold">
                        <div class="col-md-4 text-left">
                            <h4>SAFI2 SUPER SHOP</h4>
                            Mobile: 01703338080 <br>
                            Email: safi2supershop@gmail.com <br>
                            Demra, Dhaka
                        </div>
                        <div class="col-md-4 text-center">
                            @if (Request::is('sales/entry/summary'))
                                <h4>Sale Details Report</h4>
                            @elseif (Request::is('sales/return/summary'))
                                <h4>Sale Returns Report</h4>
                            @elseif (Request::is('supplier/trans/summary'))
                                <h4>Supplier Transaction Report</h4>
                            @elseif (Request::is('office/expense/summary'))
                                <h4>Office Transaction Report</h4>
                            @elseif (Request::is('office/income/summary'))
                                <h4>Office Transaction Report</h4>
                            @elseif (Request::is('employee/payment/summary'))
                                <h4>Employee Transaction Report</h4>
                            @elseif (Request::is('employee/return/summary'))
                                <h4>Employee Transaction Report</h4>
                            @endif
                            From: {{ \Carbon\Carbon::parse($fromDate)->format('Y-m-d') }} - To {{ \Carbon\Carbon::parse($toDate)->format('Y-m-d') }} <br>
                        </div>
                        <div class="col-md-4 text-right">
                            Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                        </div>
                    </div>
                    @if (Request::is('sales/entry/summary'))
                        <div class="table-responsive">
                            <table class="w-100" border="1" id="sales_entry_table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Invoice No</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Sold By</th>
                                        <th scope="col">Invoice Amount</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Paid</th>
                                        <th scope="col">Round</th>
                                        <th scope="col">Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salesDatas as $salesData)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ \Carbon\Carbon::parse($salesData->created_at)->format('Y-m-d') }}</td>
                                            <td>{{$salesData->invoiceNo}}</td>
                                            <td>{{$salesData->customer_name}} ({{$salesData->customer_type}})</td>
                                            <td>{{$salesData->user}}</td>
                                            <td>{{$salesData->cashTotal}}</td>
                                            <td>{{$salesData->cashDiscount}}</td>
                                            <td>{{$salesData->cashAmount + $salesData->cardAmount + $salesData->mobileAmount}}</td>
                                            <td>{{$salesData->cashRound}}</td>
                                            <td>{{$salesData->cashDue}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col" colspan="5" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif (Request::is('sales/return/summary'))
                        <div class="table-responsive">
                            <table class="w-100" border="1" id="sale_returns_table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Invoice No</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Return QTY</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saleReturns as $saleReturn)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ \Carbon\Carbon::parse($saleReturn->created_at)->format('Y-m-d') }}</td>
                                            <td>{{$saleReturn->invoice_no}}</td>
                                            <td>{{$saleReturn->product_name}}</td>
                                            <td>{{$saleReturn->return_qty}}</td>
                                            <td>{{$saleReturn->total}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col" colspan="4" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                        <th scope="col">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif (Request::is('supplier/trans/summary'))
                        <div class="table-responsive">
                            <table class="w-100" border="1" id="supplier_trans_table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Transaction No</th>
                                        <th scope="col">Supplier</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier_trans as $transaction)
                                        <tr>
                                            <td scope="row">{{$loop->iteration}}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</td>
                                            <td>{{$transaction->transactionNO}}</td>
                                            <td>{{$transaction->supplier_name}}</td>
                                            <td>{{$transaction->description}}</td>
                                            <td>{{$transaction->amt_paid}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col" colspan="5" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif (Request::is('office/expense/summary'))
                        <div class="table-responsive">
                            <table class="w-100" border="1" id="office_expense_table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Transaction No</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($office_expenses as $office_expense)
                                        <tr>
                                            <td scope="row">{{$loop->iteration}}</td>
                                            <td>{{ \Carbon\Carbon::parse($office_expense->created_at)->format('Y-m-d') }}</td>
                                            <td>{{$office_expense->transactionNO}}</td>
                                            <td>{{$office_expense->type}}</td>
                                            <td>{{$office_expense->description}}</td>
                                            <td>{{$office_expense->amt_paid}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col" colspan="5" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif (Request::is('office/income/summary'))
                        <div class="table-responsive">
                            <table class="w-100" border="1" id="office_income_table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Transaction No</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($office_incomes as $office_income)
                                        <tr>
                                            <td scope="row">{{$loop->iteration}}</td>
                                            <td>{{ \Carbon\Carbon::parse($office_income->created_at)->format('Y-m-d') }}</td>
                                            <td>{{$office_income->transactionNO}}</td>
                                            <td>{{$office_income->type}}</td>
                                            <td>{{$office_income->description}}</td>
                                            <td>{{$office_income->amt_paid}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col" colspan="5" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif (Request::is('employee/payment/summary'))
                        <div class="table-responsive">
                            <table class="w-100" border="1" id="employee_payment_table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Transaction No</th>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee_payments as $employee_payment)
                                        <tr>
                                            <td scope="row">{{$loop->iteration}}</td>
                                            <td>{{ \Carbon\Carbon::parse($employee_payment->created_at)->format('Y-m-d') }}</td>
                                            <td>{{$employee_payment->transactionNO}}</td>
                                            <td>{{$employee_payment->employee}}</td>
                                            <td>{{$employee_payment->trans_type}}</td>
                                            <td>{{$employee_payment->emp_trans_type}}</td>
                                            <td>{{$employee_payment->description}}</td>
                                            <td>{{$employee_payment->amt_paid}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col" colspan="7" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif (Request::is('employee/return/summary'))
                        <div class="table-responsive">
                            <table class="w-100" border="1" id="employee_return_table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Transaction No</th>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee_returns as $employee_return)
                                        <tr>
                                            <td scope="row">{{$loop->iteration}}</td>
                                            <td>{{ \Carbon\Carbon::parse($employee_return->created_at)->format('Y-m-d') }}</td>
                                            <td>{{$employee_return->transactionNO}}</td>
                                            <td>{{$employee_return->employee}}</td>
                                            <td>{{$employee_return->trans_type}}</td>
                                            <td>{{$employee_return->emp_trans_type}}</td>
                                            <td>{{$employee_return->description}}</td>
                                            <td>{{$employee_return->amt_paid}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col" colspan="7" class="text-right">Totals:</th>
                                        <th scope="col">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript files-->
    @include('admin.dash_script')

    <script>
        $(document).ready(function () {
            // Function to calculate and update sales entry footer totals
            function updateSalesTableFooter() {
                // Initialize total variables
                let totalInvoiceAmount = 0;
                let totalDiscount = 0;
                let totalPaid = 0;
                let totalRound = 0;
                let totalDue = 0;

                // Iterate through each row in the tbody
                $('#sales_entry_table tbody tr').each(function () {
                    // Parse the values from each column using .find('td').eq(index)
                    totalInvoiceAmount += parseFloat($(this).find('td').eq(5).text().trim()) || 0;
                    totalDiscount += parseFloat($(this).find('td').eq(6).text().trim()) || 0;
                    totalPaid += parseFloat($(this).find('td').eq(7).text().trim()) || 0;
                    totalRound += parseFloat($(this).find('td').eq(8).text().trim()) || 0;
                    totalDue += parseFloat($(this).find('td').eq(9).text().trim()) || 0;
                });

                // Update the footer with calculated totals
                $('#sales_entry_table tfoot tr th').eq(1).text(totalInvoiceAmount.toFixed(2));
                $('#sales_entry_table tfoot tr th').eq(2).text(totalDiscount.toFixed(2));
                $('#sales_entry_table tfoot tr th').eq(3).text(totalPaid.toFixed(2));
                $('#sales_entry_table tfoot tr th').eq(4).text(totalRound.toFixed(2));
                $('#sales_entry_table tfoot tr th').eq(5).text(totalDue.toFixed(2));
            }
            // Call the function to update totals on page load
            updateSalesTableFooter();

            // Function to calculate and update sales return footer totals
            function updateSaleReturnsTableFooter() {
                // Initialize total variables
                let totalQty = 0;
                let totalAmt = 0;

                // Iterate through each row in the tbody
                $('#sale_returns_table tbody tr').each(function () {
                    // Parse the values from each column using .find('td').eq(index)
                    totalQty += parseFloat($(this).find('td').eq(4).text().trim()) || 0;
                    totalAmt += parseFloat($(this).find('td').eq(5).text().trim()) || 0;
                });

                // Update the footer with calculated totals
                $('#sale_returns_table tfoot tr th').eq(1).text(totalQty.toFixed(2));
                $('#sale_returns_table tfoot tr th').eq(2).text(totalAmt.toFixed(2));
            }
            updateSaleReturnsTableFooter();

            // Function to calculate and update supplier transaction footer totals
            function updateSupplierTableFooter() {
                // Initialize total variables
                let totalAmt = 0;

                // Iterate through each row in the tbody
                $('#supplier_trans_table tbody tr').each(function () {
                    // Parse the values from each column using .find('td').eq(index)
                    totalAmt += parseFloat($(this).find('td').eq(5).text().trim()) || 0;
                });

                // Update the footer with calculated totals
                $('#supplier_trans_table tfoot tr th').eq(1).text(totalAmt.toFixed(2));
            }
            updateSupplierTableFooter();

            // Function to calculate and update office expense footer totals
            function updateOfficeExpenseTableFooter() {
                // Initialize total variables
                let totalAmt = 0;

                // Iterate through each row in the tbody
                $('#office_expense_table tbody tr').each(function () {
                    // Parse the values from each column using .find('td').eq(index)
                    totalAmt += parseFloat($(this).find('td').eq(5).text().trim()) || 0;
                });

                // Update the footer with calculated totals
                $('#office_expense_table tfoot tr th').eq(1).text(totalAmt.toFixed(2));
            }
            updateOfficeExpenseTableFooter();

            // Function to calculate and update office income footer totals
            function updateOfficeIncomeTableFooter() {
                // Initialize total variables
                let totalAmt = 0;

                // Iterate through each row in the tbody
                $('#office_income_table tbody tr').each(function () {
                    // Parse the values from each column using .find('td').eq(index)
                    totalAmt += parseFloat($(this).find('td').eq(5).text().trim()) || 0;
                });

                // Update the footer with calculated totals
                $('#office_income_table tfoot tr th').eq(1).text(totalAmt.toFixed(2));
            }
            updateOfficeIncomeTableFooter();

            // Function to calculate and update employee payment footer totals
            function updateEmployeePaymentTableFooter() {
                // Initialize total variables
                let totalAmt = 0;

                // Iterate through each row in the tbody
                $('#employee_payment_table tbody tr').each(function () {
                    // Parse the values from each column using .find('td').eq(index)
                    totalAmt += parseFloat($(this).find('td').eq(7).text().trim()) || 0;
                });

                // Update the footer with calculated totals
                $('#employee_payment_table tfoot tr th').eq(1).text(totalAmt.toFixed(2));
            }
            updateEmployeePaymentTableFooter();

            // Function to calculate and update employee return footer totals
            function updateEmployeeReturnTableFooter() {
                // Initialize total variables
                let totalAmt = 0;

                // Iterate through each row in the tbody
                $('#employee_return_table tbody tr').each(function () {
                    // Parse the values from each column using .find('td').eq(index)
                    totalAmt += parseFloat($(this).find('td').eq(7).text().trim()) || 0;
                });

                // Update the footer with calculated totals
                $('#employee_return_table tfoot tr th').eq(1).text(totalAmt.toFixed(2));
            }
            updateEmployeeReturnTableFooter();
        });
    </script>
  </body>
</html>
