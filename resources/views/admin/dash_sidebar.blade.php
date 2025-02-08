<nav id="sidebar">
    <!-- Sidebar Navidation Menus-->
    <ul class="list-unstyled">
        <li class="{{ Request::is('/') ? 'active' : '' }}">
            <a href="{{url('/')}}"> <i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        </li>

        <li class="{{ Request::is('user_info') || Request::is('access_control') ? 'active' : '' }}">
            <a href="#user_manage" aria-expanded="false" data-toggle="collapse">
                <i class="fas fa-user"></i><span>User Management</span>
            </a>
            <ul id="user_manage" class="collapse list-unstyled {{ Request::is('user_info') || Request::is('access_control') ? 'show' : '' }}">
                <li class="{{ Request::is('user_info') ? 'active' : '' }}">
                    <a href="{{ url('user_info') }}">Users</a>
                </li>
                @if (Auth::user()->usertype == 'Admin')
                    <li class="{{ Request::is('access_control') ? 'active' : '' }}">
                        <a href="{{ url('access_control') }}">Access Control</a>
                    </li>
                @endif
            </ul>
        </li>

        <li class="{{ Request::is('customer_info') || Request::is('customer_type') ? 'active' : '' }}">
            <a href="#customer_manage" aria-expanded="false" data-toggle="collapse">
                <i class="fas fa-users"></i><span>Customer Settings</span>
            </a>
            <ul id="customer_manage" class="collapse list-unstyled {{ Request::is('customer_info') || Request::is('customer_type') ? 'show' : '' }}">
                <li class="{{ Request::is('customer_info') ? 'active' : '' }}">
                    <a href="{{ url('customer_info') }}">Customer</a>
                </li>
                <li class="{{ Request::is('customer_type') ? 'active' : '' }}">
                    <a href="{{ url('customer_type') }}">Customer Type</a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('view_product') || Request::is('classifications') || Request::is('product/pricing') || Request::is('product/bulk-barcode') ? 'active' : '' }}">
            <a href="#product_manage" aria-expanded="false" data-toggle="collapse">
                <i class="fas fa-shopping-bag"></i><span>Product Management</span>
            </a>
            <ul id="product_manage" class="collapse list-unstyled {{ Request::is('classifications') || Request::is('view_product') || Request::is('product/pricing') || Request::is('product/bulk-barcode') ? 'show' : '' }}">
                <li class="{{ Request::is('classifications') ? 'active' : '' }}">
                    <a href="{{ url('classifications') }}">Classifications</a>
                </li>
                <li class="{{ Request::is('view_product') ? 'active' : '' }}">
                    <a href="{{ url('view_product') }}">Products</a>
                </li>
                <li class="{{ Request::is('product/bulk-barcode') ? 'active' : '' }}">
                    <a href="{{ url('product/bulk-barcode') }}">Bulk Barcode</a>
                </li>
                <li class="{{ Request::is('product/pricing') ? 'active' : '' }}">
                    <a href="{{ url('product/pricing') }}">Product Pricing</a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('supplier_info') || Request::is('#') ? 'active' : '' }}">
            <a href="#supplier_manage" aria-expanded="false" data-toggle="collapse">
                <i class="fas fa-handshake"></i><span>Suppliers</span>
            </a>
            <ul id="supplier_manage" class="collapse list-unstyled {{ Request::is('supplier_info') || Request::is('#') ? 'show' : '' }}">
                <li class="{{ Request::is('supplier_info') ? 'active' : '' }}">
                    <a href="{{ url('supplier_info') }}">Suppliers</a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('stock_in_list') || Request::is('add_stock') || Request::is('stock_out_list') || Request::is('stock_out') ? 'active' : '' }}"><a href="#stock_manage" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-layer-group"></i><span>Stock</span></a>
            <ul id="stock_manage" class="collapse list-unstyled {{ Request::is('stock_in_list') || Request::is('add_stock') || Request::is('stock_out_list') || Request::is('stock_out') ? 'show' : '' }}">
                <li class="{{ Request::is('stock_in_list') || Request::is('add_stock') ? 'active' : '' }}">
                    <a href="{{url('stock_in_list')}}">Stock In</a>
                </li>
                <li class="{{ Request::is('stock_out_list') || Request::is('stock_out') ? 'active' : '' }}">
                    <a href="{{url('stock_out_list')}}">Stock Out</a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('sales') || Request::is('sale_returns') ? 'active' : '' }}"><a href="#sales_manage" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-dollar-sign"></i><span>Sales</span></a>
            <ul id="sales_manage" class="collapse list-unstyled {{ Request::is('sales') || Request::is('sale_returns') ? 'show' : '' }}">
                <li class="{{ Request::is('sales') ? 'active' : '' }}">
                    <a href="{{ url('sales') }}">Sales</a>
                </li>
                <li class="{{ Request::is('sale_returns') ? 'active' : '' }}">
                    <a href="{{url('sale_returns')}}">Sale Returns</a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('accounts') || Request::is('banks_cards') || Request::is('expense_ctg') ? 'active' : '' }}"><a href="#accounts_settings" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-landmark"></i><span>Account Settings</span></a>
            <ul id="accounts_settings" class="collapse list-unstyled {{ Request::is('accounts') || Request::is('banks_cards') || Request::is('expense_ctg') ? 'show' : '' }}">
                <li class="{{ Request::is('accounts') ? 'active' : '' }}">
                    <a href="{{ url('accounts') }}">Accounts</a>
                </li>
                <li class="{{ Request::is('banks_cards') ? 'active' : '' }}">
                    <a href="{{url('banks_cards')}}">Banks & Cards</a>
                </li>
                <li class="{{ Request::is('expense_ctg') ? 'active' : '' }}">
                    <a href="{{url('expense_ctg')}}">Expense Categories</a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('transactions') || Request::is('fund_transfer') ? 'active' : '' }}"><a href="#accounts_manage" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-money-check-alt"></i><span>Transactions</span></a>
            <ul id="accounts_manage" class="collapse list-unstyled {{ Request::is('transactions') || Request::is('fund_transfer') ? 'show' : '' }}">
                <li class="{{ Request::is('transactions') ? 'active' : '' }}">
                    <a href="{{ url('transactions') }}">Transactions</a>
                </li>
                <li class="{{ Request::is('fund_transfer') ? 'active' : '' }}">
                    <a href="{{url('fund_transfer')}}">Fund Transfer</a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('daily_summary') || Request::is('profit_loss_report') || Request::is('sale_list') || Request::is('product_sale_report') || Request::is('sale_return_report') || Request::is('stock_report') || Request::is('stockIn_summary') || Request::is('stockOut_report') || Request::is('employee_trans_report') || Request::is('office_trans_report') || Request::is('supplier_trans_report') || Request::is('fund_transfer_report') || Request::is('customer_ledger_report') ? 'active' : '' }}"><a href="#report_manage" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-chart-bar"></i><span>Reports</span></a>
            <ul id="report_manage" class="collapse list-unstyled {{ Request::is('daily_summary') || Request::is('profit_loss_report') || Request::is('sale_list') || Request::is('product_sale_report') || Request::is('sale_return_report') || Request::is('stock_report') || Request::is('stockIn_summary') || Request::is('stockOut_report') || Request::is('employee_trans_report') || Request::is('office_trans_report') || Request::is('supplier_trans_report') || Request::is('fund_transfer_report') || Request::is('customer_ledger_report') ? 'show' : '' }}">
                <li class="{{ Request::is('profit_loss_report') ? 'active' : '' }}">
                    <a href="{{ url('profit_loss_report') }}">Profit/Loss</a>
                </li>
                <li class="{{ Request::is('daily_summary') ? 'active' : '' }}">
                    <a href="{{ url('daily_summary') }}">Daily/Monthly Summary</a>
                </li>
                <li class="{{ Request::is('sale_list') ? 'active' : '' }}">
                    <a href="{{ url('sale_list') }}">Sale Invoices</a>
                </li>
                <li class="{{ Request::is('product_sale_report') ? 'active' : '' }}">
                    <a href="{{ url('product_sale_report') }}">Product Sale Summary</a>
                </li>
                <li class="{{ Request::is('sale_return_report') ? 'active' : '' }}">
                    <a href="{{ url('sale_return_report') }}">Sale Return Report</a>
                </li>
                <li class="{{ Request::is('stock_report') ? 'active' : '' }}">
                    <a href="{{ url('stock_report') }}">Stock Report</a>
                </li>
                <li class="{{ Request::is('stockIn_summary') ? 'active' : '' }}">
                    <a href="{{ url('stockIn_summary') }}">Stock In Summary</a>
                </li>
                <li class="{{ Request::is('stockOut_report') ? 'active' : '' }}">
                    <a href="{{ url('stockOut_report') }}">Stock Out Report</a>
                </li>
                <li class="{{ Request::is('employee_trans_report') ? 'active' : '' }}">
                    <a href="{{ url('employee_trans_report') }}">Employee Transaction Report</a>
                </li>
                <li class="{{ Request::is('office_trans_report') ? 'active' : '' }}">
                    <a href="{{ url('office_trans_report') }}">Office Transaction Report</a>
                </li>
                <li class="{{ Request::is('supplier_trans_report') ? 'active' : '' }}">
                    <a href="{{ url('supplier_trans_report') }}">Supplier Transaction Report</a>
                </li>
                <li class="{{ Request::is('fund_transfer_report') ? 'active' : '' }}">
                    <a href="{{ url('fund_transfer_report') }}">Fund Transfer Report</a>
                </li>
                <li class="{{ Request::is('customer_ledger_report') ? 'active' : '' }}">
                    <a href="{{ url('customer_ledger_report') }}">Customer Ledger Report</a>
                </li>
            </ul>
        </li>
</nav>
