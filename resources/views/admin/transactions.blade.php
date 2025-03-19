<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Transactions</title>
    <style>
        #links_div a{
            display: block;
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
                <h2 class="h5 no-margin-bottom">Transactions / Transactions</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>List of Transactions</h3>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <ul class="nav nav-pills my-2" id="pills-tab">
                                        <li class="nav-item">
                                            <button class="nav-link active mt-1" data-target="#nav_link_1">Customer</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link mt-1" data-target="#nav_link_2">Supplier</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link mt-1" data-target="#nav_link_3">Office</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link mt-1" data-target="#nav_link_4">Employee</button>
                                        </li>
                                    </ul>
                                    <div id="links_div">
                                        <a href="{{ url('customer/transaction') }}">
                                            <button type="button" id="trans_cst_link" class="btn btn-primary ms-auto mt-1">Add Transaction</button>
                                        </a>
                                        <a href="{{ url('supplier/transaction') }}">
                                            <button type="button" id="trans_spl_link" class="btn btn-primary ms-auto d-none mt-1">Add Transaction</button>
                                        </a>
                                        <a href="{{ url('office/transaction') }}">
                                            <button type="button" id="trans_ofc_link" class="btn btn-primary ms-auto d-none mt-1">Add Transaction</button>
                                        </a>
                                        <a href="{{ url('employee/transaction') }}">
                                            <button type="button" id="trans_emp_link" class="btn btn-primary ms-auto d-none mt-1">Add Transaction</button>
                                        </a>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div id="nav_link_1" class="tab-pane table-responsive fade show active">
                                        <table class="datatable table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Transaction No</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Account</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($customer_transactions as $customer_transaction)
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$customer_transaction->transactionNO}}</td>
                                                        <td>{{$customer_transaction->amt_paid}}</td>
                                                        <td>{{$customer_transaction->customer_name}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($customer_transaction->pay_date)->format('d M, Y') }}</td>
                                                        <td>{{$customer_transaction->description}}</td>
                                                        <td>{{$customer_transaction->account_name}}
                                                            <br>
                                                            {{$customer_transaction->account_no}}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editBankAcc{{$customer_transaction->id}}">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="nav_link_2" class="tab-pane table-responsive fade">
                                        <table class="datatable table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Transaction No</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Supplier</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Account</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($supplier_transactions as $supplier_transaction)
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$supplier_transaction->transactionNO}}</td>
                                                        <td>{{$supplier_transaction->amt_paid}}</td>
                                                        <td>{{$supplier_transaction->supplier_name}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($supplier_transaction->pay_date)->format('d M, Y') }}</td>
                                                        <td>{{$supplier_transaction->description}}</td>
                                                        <td>{{$supplier_transaction->account_name}}
                                                            <br>
                                                            {{$supplier_transaction->account_no}}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editBankAcc{{$supplier_transaction->id}}">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="nav_link_3" class="tab-pane table-responsive fade show">
                                        <table class="datatable table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Transaction No</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Account</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($office_transactions as $office_transaction)
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$office_transaction->transactionNO}}</td>
                                                        <td>{{$office_transaction->amt_paid}}</td>
                                                        <td>{{$office_transaction->type}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($office_transaction->pay_date)->format('d M, Y') }}</td>
                                                        <td>{{$office_transaction->description}}</td>
                                                        <td>{{$office_transaction->account_name}}
                                                            <br>
                                                            {{$office_transaction->account_no}}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editBankAcc{{$office_transaction->id}}">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="nav_link_4" class="tab-pane table-responsive fade">
                                        <table class="datatable table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Transaction No</th>
                                                    <th scope="col">Employee</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Option</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Account</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($employee_transactions as $employee_transactions)
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$employee_transactions->transactionNO}}</td>
                                                        <td>{{$employee_transactions->employee}}</td>
                                                        <td>{{$employee_transactions->amt_paid}}</td>
                                                        <td>{{$employee_transactions->trans_type}}</td>
                                                        <td>{{$employee_transactions->emp_trans_type}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($employee_transactions->pay_date)->format('d M, Y') }}</td>
                                                        <td>{{$employee_transactions->description}}</td>
                                                        <td>{{$employee_transactions->account_name}}
                                                            <br>
                                                            {{$employee_transactions->account_no}}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editBankAcc{{$employee_transactions->id}}">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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

    @include('admin.dash_script')

    <!-- Nav-pills -->
    <script>
        $(document).ready(function() {
            $(".nav-link").click(function() {
                const target = $(this).data("target");
                $(".tab-pane").removeClass("show active");
                $(target).addClass("show active");
                $(".nav-link").removeClass("active");
                $(this).addClass("active");

                // Show/Hide buttons based on active link
                if (target === "#nav_link_1") {
                    $("#trans_cst_link").removeClass("d-none");
                    $("#trans_spl_link, #trans_ofc_link, #trans_emp_link").addClass("d-none");
                } else if (target === "#nav_link_2") {
                    $("#trans_spl_link").removeClass("d-none");
                    $("#trans_cst_link, #trans_ofc_link, #trans_emp_link").addClass("d-none");
                } else if (target === "#nav_link_3") {
                    $("#trans_ofc_link").removeClass("d-none");
                    $("#trans_cst_link, #trans_spl_link, #trans_emp_link").addClass("d-none");
                } else if (target === "#nav_link_4") {
                    $("#trans_emp_link").removeClass("d-none");
                    $("#trans_cst_link, #trans_spl_link, #trans_ofc_link").addClass("d-none");
                }
            });
        });
    </script>
  </body>
</html>
