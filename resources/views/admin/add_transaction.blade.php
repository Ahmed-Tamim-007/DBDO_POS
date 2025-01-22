<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Add Transactions</title>
    <style>
        .inline-radio {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .custom-radio {
            width: 20px;
            height: 12px;
            transform: scale(1.5); /* Adjust this value for desired size */
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
                <h2 class="h5 no-margin-bottom">Transactions / Add Transactions</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            @if (Request::is('customer/transaction'))
                                <!-- Customer -->
                                <div id="add_customer_trans">
                                    <h3>Add Customer Transaction</h3>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="required-label">Transaction No</label>
                                                    <input type="text" class="form-control trans_no" name="transactionNO" value="{{ $nextTransactionNumber }}" readonly>
                                                </div>
                                                <div class="col-md-6 mb-4 position-relative">
                                                    <label class="required-label">Customer</label>
                                                    <input type="text" id="customer_search" name="customer" class="form-control" autocomplete="off" placeholder="Search Customer..." required>
                                                    <input type="hidden" name="customerID" id="customerID">
                                                    <div id="customer_search_list" class="list-group" style="width: 90%;"></div>
                                                </div>

                                                <div class="col-md-12 mb-4 d-none table-responsive" id="unpaid_orders">
                                                    <label class="required-label">Unpaid Orders</label>
                                                    <table class="table table-hover" id="due_table">
                                                        <thead>
                                                            <tr class="text-primary">
                                                                <th scope="col">Invoice</th>
                                                                <th scope="col">Total</th>
                                                                <th scope="col">Due</th>
                                                                <th scope="col">Pay</th>
                                                                <th scope="col">Settle</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                        </tbody>

                                                        <tfoot>
                                                            <tr class="text-primary">
                                                                <th scope="col" colspan="2" class="text-right">Total Due:</th>
                                                                <th scope="col">0.00</th>
                                                                <th scope="col">0.00</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="required-label">Amount Paid</label>
                                                    <input type="text" class="form-control trans_amt" name="amt_paid" required>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="required-label">Payment Date</label>
                                                    <input type="date" class="form-control trans_date" name="pay_date" readonly>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="required-label">Account</label>
                                                    <select class="form-control form-select" name="account" aria-label="Default select example" required>
                                                        <option value="" selected>Select One</option>

                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}">
                                                                {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="">Description</label>
                                                    <textarea name="description" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="text-center" style="color: #019bee;">Documents</h4>
                                            <div class="p-3" style="border: 1px solid #e0e0e0;">
                                                <div class="mb-4">
                                                    <label class="">Name</label>
                                                    <input type="text" class="form-control form-control-sm" name="doc_name">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="">Description</label>
                                                    <textarea name="doc_description" class="form-control form-control-sm" rows="2"></textarea>
                                                </div>
                                                <div class="">
                                                    <label class="">Select File</label>
                                                    <input type="file" class="form-control form-control-sm" id="image" name="image">
                                                    <p class="text-primary mb-0 text-bold" style="font-size: 12px">Use jpg,jpeg,png,xls,doc,pdf only.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <input type="submit" id="customer_trans_submit" class="btn btn-primary mt-3 px-5" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            @elseif (Request::is('supplier/transaction'))
                                <!-- Supplier -->
                                <div id="add_supplier_trans">
                                    <h3>Add Supplier Transaction</h3>
                                    <form class="validate_form" action="{{url('add_supplier_trans')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Transaction No</label>
                                                        <input type="text" class="form-control trans_no" name="transactionNO" value="{{ $nextTransactionNumber }}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-4 position-relative">
                                                        <label class="required-label">Supplier</label>
                                                        <input type="text" id="supplier_search" name="supplier" class="form-control" autocomplete="off" placeholder="Search Supplier..." required>
                                                        <input type="hidden" name="supplierID" id="supplierID">
                                                        <div id="supplier_search_list" class="list-group" style="width: 90%;"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Amount Advanced</label>
                                                        <input type="text" class="form-control trans_amt" name="amt_paid" required>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Payment Date</label>
                                                        <input type="date" class="form-control trans_date" name="pay_date" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Account</label>
                                                        <select class="form-control form-select" name="account" aria-label="Default select example" required>
                                                            <option value="" selected>Select One</option>

                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}">
                                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="">Description</label>
                                                        <textarea name="description" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="text-center" style="color: #019bee;">Documents</h4>
                                                <div class="p-3" style="border: 1px solid #e0e0e0;">
                                                    <div class="mb-4">
                                                        <label class="">Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="doc_name">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="">Description</label>
                                                        <textarea name="doc_description" class="form-control form-control-sm" rows="2"></textarea>
                                                    </div>
                                                    <div class="">
                                                        <label class="">Select File</label>
                                                        <input type="file" class="form-control form-control-sm" id="image" name="image">
                                                        <p class="text-primary mb-0 text-bold" style="font-size: 12px">Use jpg,jpeg,png,xls,doc,pdf only.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <input type="submit" class="btn btn-primary mt-3 px-5" value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @elseif (Request::is('office/transaction'))
                                <!-- Office -->
                                <div id="add_office_trans">
                                    <h3>Add Office Transaction</h3>
                                    <form class="validate_form" action="{{url('add_office_trans')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Transaction No</label>
                                                        <input type="text" class="form-control trans_no" name="transactionNO" value="{{ $nextTransactionNumber }}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label for="type" class="required-label">Type</label>
                                                        <div>
                                                            <input type="radio" id="expense" class="custom-radio" name="type" value="Expense" checked>
                                                            <label for="expense" class="mr-3">Expense</label>

                                                            <input type="radio" id="income" class="custom-radio" name="type" value="Income">
                                                            <label for="income" class="mr-3">Income</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-4" id="expense_div">
                                                        <label class="required-label">Expense</label>
                                                        <select class="form-control form-select" name="exp_type" aria-label="Default select example">
                                                            <option value="" selected>Select One</option>

                                                            @foreach ($categories as $category)
                                                                @if ($category->catType == 'Expense')
                                                                    <option value="{{ $category->catName }}">
                                                                        {{ $category->catName }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4" id="income_div">
                                                        <label class="required-label">Income</label>
                                                        <select class="form-control form-select" name="exp_type" aria-label="Default select example">
                                                            <option value="" selected>Select One</option>

                                                            @foreach ($categories as $category)
                                                                @if ($category->catType == 'Income')
                                                                    <option value="{{ $category->catName }}">
                                                                        {{ $category->catName }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Amount Paid</label>
                                                        <input type="text" class="form-control trans_amt" name="amt_paid" required>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Payment Date</label>
                                                        <input type="date" class="form-control trans_date" name="pay_date" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Account</label>
                                                        <select class="form-control form-select" name="account" aria-label="Default select example" required>
                                                            <option value="" selected>Select One</option>

                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}">
                                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="">Description</label>
                                                        <textarea name="description" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="text-center" style="color: #019bee;">Documents</h4>
                                                <div class="p-3" style="border: 1px solid #e0e0e0;">
                                                    <div class="mb-4">
                                                        <label class="">Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="doc_name">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="">Description</label>
                                                        <textarea name="doc_description" class="form-control form-control-sm" rows="2"></textarea>
                                                    </div>
                                                    <div class="">
                                                        <label class="">Select File</label>
                                                        <input type="file" class="form-control form-control-sm" id="image" name="image">
                                                        <p class="text-primary mb-0 text-bold" style="font-size: 12px">Use jpg,jpeg,png,xls,doc,pdf only.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <input type="submit" id="office_trans_submit" class="btn btn-primary mt-3 px-5" value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @elseif (Request::is('employee/transaction'))
                                <!-- Employee -->
                                <div id="add_employee_trans">
                                    <h3>Add Employee Transaction</h3>
                                    <form class="validate_form" action="{{url('add_employee_trans')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Transaction No</label>
                                                        <input type="text" class="form-control trans_no" name="transactionNO" value="{{ $nextTransactionNumber }}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Employee</label>
                                                        <select class="form-control form-select" name="employee" aria-label="Default select example" required>
                                                            <option value="" selected>Select One</option>
                                                            <option value="Employee A">Employee A</option>
                                                            <option value="Employee B">Employee B</option>
                                                            <option value="Employee C">Employee C</option>

                                                            {{-- @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}">
                                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                                </option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label for="trans_type" class="required-label">Type</label>
                                                        <div>
                                                            <input type="radio" id="payment" class="custom-radio" name="trans_type" value="Payment" checked>
                                                            <label for="payment" class="mr-3">Payment</label>

                                                            <input type="radio" id="return" class="custom-radio" name="trans_type" value="Return">
                                                            <label for="return" class="mr-3">Return</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-4" id="payment_div">
                                                        <label class="required-label">Payment</label>
                                                        <select class="form-control form-select" name="emp_trans_type" aria-label="Default select example">
                                                            <option value="" selected>Select One</option>

                                                            <option value="Salary">Salary</option>
                                                            <option value="Festival Bonus">Festival Bonus</option>
                                                            <option value="Performance Bonus">Performance Bonus</option>
                                                            <option value="Incentive">Incentive</option>
                                                            <option value="Loan">Loan</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4" id="return_div">
                                                        <label class="required-label">Return</label>
                                                        <select class="form-control form-select" name="emp_trans_type" aria-label="Default select example">
                                                            <option value="" selected>Select One</option>

                                                            <option value="Fine">Fine</option>
                                                            <option value="Loan Returns">Loan Returns</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Amount Paid</label>
                                                        <input type="text" class="form-control trans_amt" name="amt_paid" required>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Payment Date</label>
                                                        <input type="date" class="form-control trans_date" name="pay_date" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="required-label">Account</label>
                                                        <select class="form-control form-select" name="account" aria-label="Default select example" required>
                                                            <option value="" selected>Select One</option>

                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}">
                                                                    {{ $account->acc_name }} &nbsp; {{ $account->acc_no }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="">Description</label>
                                                        <textarea name="description" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="text-center" style="color: #019bee;">Documents</h4>
                                                <div class="p-3" style="border: 1px solid #e0e0e0;">
                                                    <div class="mb-4">
                                                        <label class="">Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="doc_name">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="">Description</label>
                                                        <textarea name="doc_description" class="form-control form-control-sm" rows="2"></textarea>
                                                    </div>
                                                    <div class="">
                                                        <label class="">Select File</label>
                                                        <input type="file" class="form-control form-control-sm" id="image" name="image">
                                                        <p class="text-primary mb-0 text-bold" style="font-size: 12px">Use jpg,jpeg,png,xls,doc,pdf only.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <input type="submit" class="btn btn-primary mt-3 px-5" value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
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

    <!-- JS for Others -->
    <script>
        $(document).ready(function() {
            // Get current date in YYYY-MM-DD format
            let currentDate = new Date().toISOString().split('T')[0];

            // Set the value of the input with class trans_date
            $('.trans_date').val(currentDate);

            $('.trans_amt').on('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, ''); // Allow numbers and decimals
                if ((this.value.match(/\./g) || []).length > 1) {
                    this.value = this.value.replace(/\.+$/, ''); // Remove extra decimals
                }
            });

            // Initially hide the Income category, show the Expense category, and set the name attribute
            $('#income_div').addClass('d-none');
            $('#expense_div').removeClass('d-none');
            $('#income_div select').removeAttr('name');
            $('#expense_div select').attr('name', 'exp_type');

            // Listen for changes in the radio button selection
            $('input[name="type"]').change(function () {
                if ($(this).val() === 'Expense') {
                    $('#income_div').addClass('d-none');
                    $('#expense_div').removeClass('d-none');

                    // Update name attributes
                    $('#income_div select').removeAttr('name');
                    $('#expense_div select').attr('name', 'exp_type');
                } else if ($(this).val() === 'Income') {
                    $('#expense_div').addClass('d-none');
                    $('#income_div').removeClass('d-none');

                    // Update name attributes
                    $('#expense_div select').removeAttr('name');
                    $('#income_div select').attr('name', 'exp_type');
                }
            });


            // Initially hide the Return category, show the Payment category, and set the name attribute
            $('#return_div').addClass('d-none');
            $('#payment_div').removeClass('d-none');
            $('#return_div select').removeAttr('name');
            $('#payment_div select').attr('name', 'emp_trans_type');

            // Listen for changes in the radio button selection
            $('input[name="trans_type"]').change(function () {
                if ($(this).val() === 'Payment') {
                    $('#return_div').addClass('d-none');
                    $('#payment_div').removeClass('d-none');

                    // Update name attributes
                    $('#return_div select').removeAttr('name');
                    $('#payment_div select').attr('name', 'emp_trans_type');
                } else if ($(this).val() === 'Return') {
                    $('#payment_div').addClass('d-none');
                    $('#return_div').removeClass('d-none');

                    // Update name attributes
                    $('#payment_div select').removeAttr('name');
                    $('#return_div select').attr('name', 'emp_trans_type');
                }
            });
        });
    </script>
    <!-- JS For customer search and customer Due and Submission -->
    <script>
        $(document).ready(function () {
            $('#customer_search').on('keyup', function () {
                let query = $(this).val();

                // Clear the phone and due if the input is empty

                if (!query) {
                    $('#customer_search_list').html('');
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
                                             data-id="${customer.id}">
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

            const sale_details = @json($sale_details);

            // Function to calculate the total due
            function updateTotalDue() {
                let totalDue = 0;

                // Iterate through each row in the Due column
                $('#due_table tbody tr').each(function () {
                    let dueValue = parseFloat($(this).find('td:eq(2)').text().trim()) || 0;
                    totalDue += dueValue;
                });

                // Update the Total Due field in the tfoot
                $('#due_table tfoot tr:eq(0) th:eq(1)').text(totalDue.toFixed(2));
            }

            // Function to calculate the Payable Amount
            function updatePayableAmount() {
                let totalPayable = 0;

                // Iterate through each input in the .due_pay fields
                $('#due_table tbody .due_pay').each(function () {
                    let payValue = parseFloat($(this).val().trim()) || 0;
                    totalPayable += payValue;
                });

                // Update the Payable field in the tfoot
                $('#due_table tfoot tr:eq(0) th:eq(2)').text(totalPayable.toFixed(2));
                $('input[name="amt_paid"]').val(totalPayable.toFixed(2));
            }

            // Recalculate Total Due when unpaid orders are loaded
            $(document).on('click', '#customer_search_list .list-group-customer', function (e) {
                e.preventDefault();

                let selectedName = $(this).text().trim();
                let customerId = $(this).data('id');

                // Find the matching sale detail
                const relatedSales = sale_details.filter(sales => sales.customerID === customerId && sales.cashDue > 0 && sales.dueSettled == 'no');

                if (relatedSales.length === 0) {
                    alert("No dues found for this customer.");
                    return;
                }

                // Show the Due Div
                $('#unpaid_orders').removeClass('d-none');
                // Clear the previous rows
                $('#due_table tbody').empty();

                // Append rows for each related sale
                relatedSales.forEach(sale => {
                    $('#due_table tbody').append(`
                        <tr>
                            <td>${sale.invoiceNo}</td>
                            <td>${sale.cashTotal}</td>
                            <td>${sale.cashDue}</td>
                            <td><input type="text" class="form-control form-control-sm trans_amt due_pay"></td>
                            <td class="td-check">
                                <label class="custom-checkbox">
                                    <input type="checkbox" value="">
                                    <span></span>
                                </label>
                            </td>
                        </tr>
                    `);
                });

                $('#customer_search').val(selectedName);
                $('#customerID').val(customerId);
                $('#customer_search_list').html(''); // Clear the suggestions list

                // After appending rows, calculate the Total Due
                updateTotalDue();
            });

            // Listen for input changes in .due_pay fields
            $(document).on('input', '.due_pay', function () {
                updatePayableAmount();
            });

            // Clear everything when the input is empty
            $('#customer_search').on('input', function () {
                if (!$(this).val().trim()) {
                    $('#customerID').val(''); // Clear hidden customer ID
                    $('#customer_search_list').html(''); // Clear suggestions
                    $('#due_table tbody').empty();
                    $('#unpaid_orders').addClass('d-none');

                    // Reset the Total Due and Payable Amount
                    $('#due_table tfoot tr:eq(0) th:eq(2)').text('0.00');
                    $('#due_table tfoot tr:eq(0) th:eq(3)').text('0.00');
                    $('input[name="amt_paid"]').empty();
                }
            });

            // Sending Data to Backend
            $('#customer_trans_submit').on('click', function () {
                const transactionNO = $('input[name="transactionNO"]').val();
                const customerID = $('input[name="customerID"]').val();
                const amt_paid = $('input[name="amt_paid"]').val();
                const pay_date = $('input[name="pay_date"]').val();
                const account = $('select[name="account"]').val();
                const description = $('textarea[name="description"]').val();
                const doc_name = $('input[name="doc_name"]').val();
                const doc_description = $('textarea[name="doc_description"]').val();
                const image = $('input[name="image"]')[0].files[0];

                // Validate required fields
                if (!customerID || !amt_paid || !account) {
                    alert('Please fill out the required fields before saving.');
                    return;
                }

                const rows = [];

                // Loop through each row in the table and collect row data
                $('#due_table tbody tr').each(function () {
                    rows.push({
                        invoiceNo: $(this).find('td:eq(0)').text(),
                        dueAmt: parseFloat($(this).find('td:eq(2)').text()),
                        paid: parseFloat($(this).find('.due_pay').val()) || 0,
                        isSettled: $(this).find('td:eq(4) input[type="checkbox"]').prop('checked') ? 'yes' : 'no',
                    });
                });

                // Prepare the form data including stock_hidden data
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}'); // CSRF token for security
                formData.append('transactionNO', transactionNO);
                formData.append('customerID', customerID);
                formData.append('amt_paid', amt_paid);
                formData.append('pay_date', pay_date);
                formData.append('account', account);
                formData.append('description', description);
                formData.append('doc_name', doc_name);
                formData.append('doc_description', doc_description);
                formData.append('image', image);  // Append the file for the image
                formData.append('rows', JSON.stringify(rows));  // Convert rows array to string for backend

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("save.customer.transaction") }}',
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
                                            ${supplier.supplier_name.trim()} (${supplier.phone.trim()})
                                         </a>`;
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
