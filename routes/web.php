<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Frontend website routes
Route::get('/', [HomeController::class, 'home']);
Route::get('/dashboard', [HomeController::class, 'login_home'])->middleware(['auth', 'verified'])->name('dashboard');
route::get('shop', [HomeController::class, 'shop']);
route::get('about', [HomeController::class, 'about']);
route::get('contact', [HomeController::class, 'contact']);

route::get('product_details/{id}', [HomeController::class, 'product_details']);
route::get('category_details/{id}', [HomeController::class, 'category_details']);

route::get('add_cart/{id}', [HomeController::class, 'add_cart'])->middleware(['auth', 'verified']);
route::get('mycart', [HomeController::class, 'mycart'])->middleware(['auth', 'verified']);
route::get('remove_cart/{id}', [HomeController::class, 'remove_cart'])->middleware(['auth', 'verified']);
route::post('confirm_order', [HomeController::class, 'confirm_order'])->middleware(['auth', 'verified']);
Route::get('/myorders', [HomeController::class, 'myorders'])->middleware(['auth', 'verified']);
Route::get('/myreview', [HomeController::class, 'myreview'])->middleware(['auth', 'verified']);

// Product search
Route::get('/search', [HomeController::class, 'search'])->name('products.search');

// CartItem Increment OR Decrement routes
Route::patch('/increment_quantity/{id}', [HomeController::class, 'incrementQuantity'])->name('cart.increment');
Route::patch('/decrement_quantity/{id}', [HomeController::class, 'decrementQuantity'])->name('cart.decrement');

// Stripe routes
Route::controller(HomeController::class)->group(function(){
    Route::get('stripe/{value}', 'stripe');
    Route::post('stripe/{value}', 'stripePost')->name('stripe.post');
});


// ---------------------------------------------------------------------------------------------------------


// Admin Panel Routes
route::get('admin/dashboard', [HomeController::class, 'index'])-> middleware('auth', 'admin');


// User Routes
route::get('user_info', [AdminController::class, 'user_info'])-> middleware('auth', 'admin');
route::post('add_user', [AdminController::class, 'add_user'])-> middleware('auth', 'admin');
route::post('edit_user/{id}', [AdminController::class, 'edit_user'])-> middleware('auth', 'admin');
route::get('delete_user/{id}', [AdminController::class, 'delete_user'])-> middleware('auth', 'admin');


// Customer Routes
route::get('customer_info', [AdminController::class, 'customer_info'])-> middleware('auth', 'admin');
route::post('add_customer', [AdminController::class, 'add_customer'])-> middleware('auth', 'admin');
route::post('edit_customer/{id}', [AdminController::class, 'edit_customer'])-> middleware('auth', 'admin');
route::get('delete_customer/{id}', [AdminController::class, 'delete_customer'])-> middleware('auth', 'admin');

route::get('customer_type', [AdminController::class, 'customer_type'])-> middleware('auth', 'admin');
route::post('add_customer_type', [AdminController::class, 'add_customer_type'])-> middleware('auth', 'admin');
route::post('edit_customer_type/{id}', [AdminController::class, 'edit_customer_type'])-> middleware('auth', 'admin');
route::get('delete_customer_type/{id}', [AdminController::class, 'delete_customer_type'])-> middleware('auth', 'admin');


// Customer Routes
route::get('supplier_info', [AdminController::class, 'supplier_info'])-> middleware('auth', 'admin');
route::post('add_supplier', [AdminController::class, 'add_supplier'])-> middleware('auth', 'admin');
route::post('edit_supplier/{id}', [AdminController::class, 'edit_supplier'])-> middleware('auth', 'admin');
route::get('delete_supplier/{id}', [AdminController::class, 'delete_supplier'])-> middleware('auth', 'admin');


// Category/Subcategory/Brand Routes
route::get('classifications', [AdminController::class, 'classifications'])-> middleware('auth', 'admin');

route::post('add_category', [AdminController::class, 'add_category'])-> middleware('auth', 'admin');
route::post('update_category/{id}', [AdminController::class, 'update_category'])-> middleware('auth', 'admin');
route::get('delete_category/{id}', [AdminController::class, 'delete_category'])-> middleware('auth', 'admin');

route::post('add_sub_category', [AdminController::class, 'add_sub_category'])-> middleware('auth', 'admin');
route::post('update_sub_category/{id}', [AdminController::class, 'update_sub_category'])-> middleware('auth', 'admin');
route::get('delete_sub_category/{id}', [AdminController::class, 'delete_sub_category'])-> middleware('auth', 'admin');

route::post('add_brand', [AdminController::class, 'add_brand'])-> middleware('auth', 'admin');
route::post('update_brand/{id}', [AdminController::class, 'update_brand'])-> middleware('auth', 'admin');
route::get('delete_brand/{id}', [AdminController::class, 'delete_brand'])-> middleware('auth', 'admin');

route::post('add_unit', [AdminController::class, 'add_unit'])-> middleware('auth', 'admin');
route::post('update_unit/{id}', [AdminController::class, 'update_unit'])-> middleware('auth', 'admin');
route::get('delete_unit/{id}', [AdminController::class, 'delete_unit'])-> middleware('auth', 'admin');


// Product Routes
route::get('view_product', [AdminController::class, 'view_product'])-> middleware('auth', 'admin');
route::post('upload_product', [AdminController::class, 'upload_product'])-> middleware('auth', 'admin');
route::post('edit_products/{id}', [AdminController::class, 'edit_products'])-> middleware('auth', 'admin');
route::get('delete_product/{id}', [AdminController::class, 'delete_product'])-> middleware('auth', 'admin');


// Stock In/Inventory routes
route::get('stock_in_list', [AdminController::class, 'stock_in_list'])-> middleware('auth', 'admin');
route::get('invoice_details/{id}', [AdminController::class, 'invoice_details'])-> middleware('auth', 'admin');
route::get('add_stock', [AdminController::class, 'add_stock'])-> middleware('auth', 'admin');
route::get('/search-products', [AdminController::class, 'stock_search'])->name('search.products');
route::get('/get-next-stock-invoice', [AdminController::class, 'getNextStockInvoice'])->name('get.next.stock.invoice');
route::post('/save-stock', [AdminController::class, 'saveStock'])->name('save.stock');
// StockOut routes
route::get('stock_out_list', [AdminController::class, 'stock_out_list'])-> middleware('auth', 'admin');
route::get('invoice_so_details/{id}', [AdminController::class, 'invoice_so_details'])-> middleware('auth', 'admin');
route::get('stock_out', [AdminController::class, 'stock_out'])-> middleware('auth', 'admin');
route::post('/get-product-batches', [AdminController::class, 'getProductBatches']);
route::post('/get-batch-details', [AdminController::class, 'getBatchDetails']);
route::get('/get-next-stock-out-invoice', [AdminController::class, 'getNextStockOutInvoice'])->name('get.next.stock.out.invoice');
route::post('/save-stock-out', [AdminController::class, 'saveStockOut'])->name('save.stock.out');


// Sales routes
route::get('/sales', [AdminController::class, 'sales'])-> middleware('auth', 'admin')->name('sales.create');
route::get('/search-sales-products', [AdminController::class, 'sales_search'])->name('search.sales.products');
Route::get('/search-sales-customers', [AdminController::class, 'customer_search'])->name('search.sales.customers');
route::post('/save-sales', [AdminController::class, 'saveSales'])->name('save.sales');
// Sale Rerurns routes
route::get('sale_returns', [AdminController::class, 'sale_returns'])-> middleware('auth', 'admin');
route::post('/save-return', [AdminController::class, 'saveReturn'])->name('save.return');
// Hold Sales routes
route::post('/hold-sales', [AdminController::class, 'holdSales'])->name('hold.sales');
Route::post('/delete-hold-sale', [AdminController::class, 'deleteHoldSale'])->name('deleteHoldSale');

// Account Settings Routes
route::get('banks_cards', [AdminController::class, 'banks_cards'])-> middleware('auth', 'admin');
route::post('add_bank', [AdminController::class, 'add_bank'])-> middleware('auth', 'admin');
route::post('update_bank/{id}', [AdminController::class, 'update_bank'])-> middleware('auth', 'admin');
route::get('delete_bank/{id}', [AdminController::class, 'delete_bank'])-> middleware('auth', 'admin');
route::post('add_card', [AdminController::class, 'add_card'])-> middleware('auth', 'admin');
route::post('update_card/{id}', [AdminController::class, 'update_card'])-> middleware('auth', 'admin');
route::get('delete_card/{id}', [AdminController::class, 'delete_card'])-> middleware('auth', 'admin');

route::get('accounts', [AdminController::class, 'accounts'])-> middleware('auth', 'admin');
route::post('add_bankAcc', [AdminController::class, 'add_bankAcc'])-> middleware('auth', 'admin');
route::post('update_bankAcc/{id}', [AdminController::class, 'update_bankAcc'])-> middleware('auth', 'admin');
route::get('delete_bankAcc/{id}', [AdminController::class, 'delete_bankAcc'])-> middleware('auth', 'admin');
route::post('add_cashAcc', [AdminController::class, 'add_cashAcc'])-> middleware('auth', 'admin');
route::post('update_cashAcc/{id}', [AdminController::class, 'update_cashAcc'])-> middleware('auth', 'admin');
route::get('delete_cashAcc/{id}', [AdminController::class, 'delete_cashAcc'])-> middleware('auth', 'admin');
route::post('add_mobileAcc', [AdminController::class, 'add_mobileAcc'])-> middleware('auth', 'admin');
route::post('update_mobileAcc/{id}', [AdminController::class, 'update_mobileAcc'])-> middleware('auth', 'admin');
route::get('delete_mobileAcc/{id}', [AdminController::class, 'delete_mobileAcc'])-> middleware('auth', 'admin');
route::post('add_stationAcc', [AdminController::class, 'add_stationAcc'])-> middleware('auth', 'admin');
route::post('update_stationAcc/{id}', [AdminController::class, 'update_stationAcc'])-> middleware('auth', 'admin');
route::get('delete_stationAcc/{id}', [AdminController::class, 'delete_stationAcc'])-> middleware('auth', 'admin');

route::get('expense_ctg', [AdminController::class, 'expense_ctg'])-> middleware('auth', 'admin');
route::post('add_trans_cat', [AdminController::class, 'add_trans_cat'])-> middleware('auth', 'admin');
route::post('update_trans_cat/{id}', [AdminController::class, 'update_trans_cat'])-> middleware('auth', 'admin');
route::get('delete_trans_cat/{id}', [AdminController::class, 'delete_trans_cat'])-> middleware('auth', 'admin');

// Transaction related routes
route::get('transactions', [AdminController::class, 'transactions'])-> middleware('auth', 'admin');

route::get('customer/transaction', [AdminController::class, 'customer_trans'])-> middleware('auth', 'admin');
route::post('/save-customer-transaction', [AdminController::class, 'add_customer_trans'])->name('save.customer.transaction');

route::get('supplier/transaction', [AdminController::class, 'supplier_trans'])-> middleware('auth', 'admin');
Route::get('/search-suppliers', [AdminController::class, 'supplier_search'])->name('search.suppliers');
route::post('add_supplier_trans', [AdminController::class, 'add_supplier_trans'])-> middleware('auth', 'admin');

route::get('office/transaction', [AdminController::class, 'office_trans'])-> middleware('auth', 'admin');
route::post('add_office_trans', [AdminController::class, 'add_office_trans'])-> middleware('auth', 'admin');

route::get('employee/transaction', [AdminController::class, 'employee_trans'])-> middleware('auth', 'admin');
route::post('add_employee_trans', [AdminController::class, 'add_employee_trans'])-> middleware('auth', 'admin');

// Fund Transfer Routes
route::get('fund_transfer', [AdminController::class, 'fund_transfer'])-> middleware('auth', 'admin');
Route::get('/get-account-balance', [AdminController::class, 'getBalance']);
route::post('add_fund_trans', [AdminController::class, 'add_fund_trans'])-> middleware('auth', 'admin');

// All Report Routes ------------------------------------------------------------>

// Profit/Loss Report Routes
route::get('profit_loss_report', [ReportController::class, 'profit_loss_report'])-> middleware('auth', 'admin');
Route::post('/search-profit-loss-reports', [ReportController::class, 'searchProfitLossReport'])->name('search.profit.loss.reports');

// Sell Invoice Report Routes
route::get('sale_list', [ReportController::class, 'sale_list'])-> middleware('auth', 'admin');
Route::post('/search-sales-reports', [ReportController::class, 'searchSalesReports'])->name('search.sales.reports');

// Daily Summary Report Routes
route::get('daily_summary', [ReportController::class, 'daily_summary'])-> middleware('auth', 'admin');
Route::post('/daily-summary-reports', [ReportController::class, 'dailySummaryReports'])->name('daily.summary.reports');
Route::get('/sales/entry/summary', [ReportController::class, 'sales_entry_summary'])->name('sales.entry.summary');
Route::get('/sales/return/summary', [ReportController::class, 'sales_return_summary'])->name('sales.return.summary');
Route::get('/supplier/trans/summary', [ReportController::class, 'supplier_trans_summary'])->name('supplier.trans.summary');
Route::get('/office/expense/summary', [ReportController::class, 'office_expense_summary'])->name('office.expense.summary');
Route::get('/office/income/summary', [ReportController::class, 'office_income_summary'])->name('office.income.summary');
Route::get('/employee/payment/summary', [ReportController::class, 'employee_payment_summary'])->name('employee.payment.summary');
Route::get('/employee/return/summary', [ReportController::class, 'employee_return_summary'])->name('employee.return.summary');

// Product Sale Report Routes
route::get('product_sale_report', [ReportController::class, 'product_sale_report'])-> middleware('auth', 'admin');
Route::post('/search-product-report', [ReportController::class, 'searchProductReport'])->name('search.product.report');

// Sale Return Report Routes
route::get('sale_return_report', [ReportController::class, 'sale_return_report'])-> middleware('auth', 'admin');
Route::post('/search-saleReturn-report', [ReportController::class, 'searchSaleReturnReport'])->name('search.saleReturn.report');

// Employee Transaction Report Routes
route::get('employee_trans_report', [ReportController::class, 'employee_trans_report'])-> middleware('auth', 'admin');
Route::post('/employee-trans-report', [ReportController::class, 'employeeTransReport'])->name('employee.trans.report');

// Office Transaction Report Routes
route::get('office_trans_report', [ReportController::class, 'office_trans_report'])-> middleware('auth', 'admin');
Route::post('/office-trans-report', [ReportController::class, 'officeTransReport'])->name('office.trans.report');

// Supplier Transaction Report Routes
route::get('supplier_trans_report', [ReportController::class, 'supplier_trans_report'])-> middleware('auth', 'admin');
Route::post('/supplier-trans-report', [ReportController::class, 'supplierTransReport'])->name('supplier.trans.report');

// Fund Transfer Report Routes
route::get('fund_transfer_report', [ReportController::class, 'fund_transfer_report'])-> middleware('auth', 'admin');
Route::post('/fund-transfer-report', [ReportController::class, 'fundTransferReport'])->name('fund.transfer.report');

// Stock Report Routes
route::get('stock_report', [ReportController::class, 'stock_report'])-> middleware('auth', 'admin');
Route::post('/search-stock-report', [ReportController::class, 'searchStockReport'])->name('search.stock.report');

// Stock In Summary Routes
route::get('stockIn_summary', [ReportController::class, 'stockIn_summary'])-> middleware('auth', 'admin');
Route::post('/search-stockIn-summary', [ReportController::class, 'searchStockInSum'])->name('search.stockIn.summary');

// Stock Out Report Routes
route::get('stockOut_report', [ReportController::class, 'stockOut_report'])-> middleware('auth', 'admin');
Route::post('/search-stockOut-report', [ReportController::class, 'searchStockOutReport'])->name('search.stockOut.report');
