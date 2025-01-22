<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PosUser;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockDetail;
use App\Models\StockOut;
use App\Models\StockOutDetail;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleReturn;
use App\Models\HoldSale;
use App\Models\Account;
use App\Models\BankName;
use App\Models\CardName;
use App\Models\ExpenseCategory;
use App\Models\CustomerTransaction;
use App\Models\SupplierTransaction;
use App\Models\OfficeTransaction;
use App\Models\EmployeeTransaction;
use App\Models\FundTransfer;

class ReportController extends Controller
{
    // Stock Reports Functions
    public function profit_loss_report()
    {
        $profitLossData = collect();
        return view('admin.profit_loss_report', compact('profitLossData'));
    }
    public function searchProfitLossReport(Request $request)
    {
        $fromDate = $request->from_date ? Carbon::parse($request->from_date)->startOfDay() : null;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        // Sales data grouped by day for cashPaid
        $sales = DB::table('sale_details')
            ->selectRaw('DATE(created_at) as date, SUM(cashPaid) as total_sales_amount, SUM(cashRound) as total_round_amount')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Purchase cost data grouped by day
        $purchaseCosts = DB::table('sales')
            ->leftJoin('stock_ins', function ($join) {
                $join->on('sales.product_id', '=', 'stock_ins.product_id')
                    ->on('sales.batch_no', '=', 'stock_ins.batch_no');
            })
            ->selectRaw(
                'DATE(sales.created_at) as date,
                SUM(stock_ins.purchase_price * sales.so_qty) as total_purchase_cost'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('sales.created_at', [$fromDate, $toDate]);
            })
            ->groupBy(DB::raw('DATE(sales.created_at)'))
            ->get();

        // Sale returns data grouped by day including buying price
        $saleReturns = DB::table('sale_returns')
            ->leftJoin('stock_ins', function ($join) {
                $join->on('sale_returns.product_id', '=', 'stock_ins.product_id')
                    ->on('sale_returns.batch_no', '=', 'stock_ins.batch_no');
            })
            ->selectRaw(
                'DATE(sale_returns.created_at) as date,
                SUM(sale_returns.total) as total_returns_amount,
                SUM(stock_ins.purchase_price * sale_returns.return_qty) as total_returns_cost'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('sale_returns.created_at', [$fromDate, $toDate]);
            })
            ->groupBy(DB::raw('DATE(sale_returns.created_at)'))
            ->get();

        // Merge and normalize data into a single dataset by date
        $profitLossData = collect();

        $dates = $sales->pluck('date')
            ->merge($purchaseCosts->pluck('date'))
            ->merge($saleReturns->pluck('date'))
            ->unique();

        foreach ($dates as $date) {
            $salesData = $sales->firstWhere('date', $date);
            $purchaseData = $purchaseCosts->firstWhere('date', $date);
            $returnsData = $saleReturns->firstWhere('date', $date);

            $totalSalesAmount = $salesData->total_sales_amount ?? 0;
            $totalPurchaseCost = $purchaseData->total_purchase_cost ?? 0;
            $totalReturnsAmount = $returnsData->total_returns_amount ?? 0;
            $totalReturnsCost = $returnsData->total_returns_cost ?? 0;
            $totalRoundAmount = $salesData->total_round_amount ?? 0;

            $profitLossData->push([
                'date' => $date,
                'total_sales_amount' => $totalSalesAmount,
                'total_purchase_cost' => $totalPurchaseCost,
                'total_returns_amount' => $totalReturnsAmount,
                'total_round_amount' => $totalRoundAmount,
                'total_returns_cost' => $totalReturnsCost,
                'profit_or_loss' => $totalSalesAmount - $totalPurchaseCost - $totalReturnsAmount + $totalRoundAmount + $totalReturnsCost,
            ]);
        }

        // Return view with data
        return view('admin.profit_loss_report', compact('profitLossData', 'fromDate', 'toDate'));
    }

    // Sales Reports Functions
    public function sale_list()
    {
        $sale_details = collect(); // Empty collection by default
        $customers = Customer::all();
        $customer_types = CustomerType::all();
        $users = PosUser::all();

        return view('admin.sales_list', compact('sale_details', 'customers', 'customer_types', 'users'));
    }
    public function searchSalesReports(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $sale_details = DB::table('sale_details')
            ->leftJoin('customers', 'sale_details.customerID', '=', 'customers.id')
            ->select(
                'sale_details.*',
                'customers.name as customer_name',
                'customers.type as customer_type'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('sale_details.created_at', [$fromDate, $toDate]);
            })
            ->when($request->invoice, function ($query) use ($request) {
                $query->where('sale_details.invoiceNo', 'like', '%' . $request->invoice . '%');
            })
            ->when($request->c_name, function ($query) use ($request) {
                $query->where('customers.id', $request->c_name);
            })
            ->when($request->c_type, function ($query) use ($request) {
                $query->where('customers.type', $request->c_type);
            })
            ->when($request->user, function ($query) use ($request) {
                $query->where('sale_details.user', $request->user);
            })
            ->get();

        // Additional data
        $customers = Customer::all();
        $customer_types = CustomerType::all();
        $users = PosUser::all();
        $sales = Sale::all();

        // Return the view
        return view('admin.sales_list', compact('sale_details', 'customers', 'customer_types', 'users', 'sales', 'fromDate', 'toDate'));
    }

    // Daily Summary Reports Functions
    public function daily_summary()
    {
        $fromDate = "";
        $toDate = "";
        $sales_summary = "";
        $sale_returns_summary = "";
        $suppliers_summary = "";
        $office_expense_summary = "";
        $office_income_summary = "";
        $employee_payment_summary = "";
        $employee_return_summary = "";

        return view('admin.daily_summary', compact('fromDate', 'toDate', 'sales_summary', 'sale_returns_summary', 'suppliers_summary', 'office_expense_summary', 'office_income_summary', 'employee_payment_summary', 'employee_return_summary'));
    }
    public function dailySummaryReports(Request $request)
    {
        // Retrieve the input dates
        $fromDate = $request->from_date;
        $toDate = Carbon::parse($request->to_date)->endOfDay()->format('Y-m-d H:i:s'); // Include the entire day

        // Query the database to calculate totals
        $sales_summary = DB::table('sale_details')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->selectRaw('
                SUM(cashTotal) as total_amount,
                SUM(cashAmount + cardAmount + mobileAmount) as total_paid,
                SUM(cashDue) as total_due
            ')
            ->first();

        $sale_returns_summary = DB::table('sale_returns')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->selectRaw('
                SUM(total) as total_amount
            ')
            ->first();

        $suppliers_summary = DB::table('supplier_transactions')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->selectRaw('
                SUM(amt_paid) as total_amount
            ')
            ->first();

        $office_expense_summary = DB::table('office_transactions')
            ->where('type', 'Expense')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->selectRaw('
                SUM(amt_paid) as total_amount
            ')
            ->first();

        $office_income_summary = DB::table('office_transactions')
            ->where('type', 'Income')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->selectRaw('
                SUM(amt_paid) as total_amount
            ')
            ->first();

        $employee_payment_summary = DB::table('employee_transactions')
            ->where('trans_type', 'Payment')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->selectRaw('
                SUM(amt_paid) as total_amount
            ')
            ->first();

        $employee_return_summary = DB::table('employee_transactions')
            ->where('trans_type', 'Return')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->selectRaw('
                SUM(amt_paid) as total_amount
            ')
            ->first();

        // Return the view
        return view('admin.daily_summary', compact('fromDate', 'toDate', 'sales_summary', 'sale_returns_summary', 'suppliers_summary', 'office_expense_summary', 'office_income_summary', 'employee_payment_summary', 'employee_return_summary'));
    }
    public function sales_entry_summary(Request $request)
    {
        // Retrieve or set default dates
        $fromDate = $request->query('fDate') ?? now()->startOfMonth()->toDateString();
        $toDate = $request->query('tDate') ?? now()->endOfMonth()->toDateString();

        // Ensure the toDate covers the full day
        $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

        // Fetch data from the `sale_details` table based on the date range
        $salesDatas = DB::table('sale_details')
            ->leftJoin('customers', 'sale_details.customerID', '=', 'customers.id')
            ->select(
                'sale_details.*',
                'customers.name as customer_name',
                'customers.type as customer_type'
            )
            ->whereBetween('sale_details.created_at', [$fromDate, $toDate])
            ->get();

        // Return the view
        return view('admin.summary_page', compact('fromDate', 'toDate', 'salesDatas'));
    }
    public function sales_return_summary(Request $request)
    {
        // Retrieve or set default dates
        $fromDate = $request->query('fDate') ?? now()->startOfMonth()->toDateString();
        $toDate = $request->query('tDate') ?? now()->endOfMonth()->toDateString();

        // Ensure the toDate covers the full day
        $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

        $saleReturns = DB::table('sale_returns')
            ->whereBetween('sale_returns.created_at', [$fromDate, $toDate])
            ->get();

        // Return the view
        return view('admin.summary_page', compact('fromDate', 'toDate', 'saleReturns'));
    }
    public function supplier_trans_summary(Request $request)
    {
        // Retrieve or set default dates
        $fromDate = $request->query('fDate') ?? now()->startOfMonth()->toDateString();
        $toDate = $request->query('tDate') ?? now()->endOfMonth()->toDateString();

        // Ensure the toDate covers the full day
        $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

        $supplier_trans = DB::table('supplier_transactions')
            ->leftJoin('suppliers', 'supplier_transactions.supplierID', '=', 'suppliers.id')
            ->select(
                'supplier_transactions.*',
                'suppliers.supplier_name as supplier_name'
            )
            ->whereBetween('supplier_transactions.created_at', [$fromDate, $toDate])
            ->get();

        // Return the view
        return view('admin.summary_page', compact('fromDate', 'toDate', 'supplier_trans'));
    }
    public function office_expense_summary(Request $request)
    {
        // Retrieve or set default dates
        $fromDate = $request->query('fDate') ?? now()->startOfMonth()->toDateString();
        $toDate = $request->query('tDate') ?? now()->endOfMonth()->toDateString();

        // Ensure the toDate covers the full day
        $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

        $office_expenses = DB::table('office_transactions')
            ->where('type', 'Expense')
            ->whereBetween('office_transactions.created_at', [$fromDate, $toDate])
            ->get();

        // Return the view
        return view('admin.summary_page', compact('fromDate', 'toDate', 'office_expenses'));
    }
    public function office_income_summary(Request $request)
    {
        // Retrieve or set default dates
        $fromDate = $request->query('fDate') ?? now()->startOfMonth()->toDateString();
        $toDate = $request->query('tDate') ?? now()->endOfMonth()->toDateString();

        // Ensure the toDate covers the full day
        $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

        $office_incomes = DB::table('office_transactions')
            ->where('type', 'Income')
            ->whereBetween('office_transactions.created_at', [$fromDate, $toDate])
            ->get();

        // Return the view
        return view('admin.summary_page', compact('fromDate', 'toDate', 'office_incomes'));
    }
    public function employee_payment_summary(Request $request)
    {
        // Retrieve or set default dates
        $fromDate = $request->query('fDate') ?? now()->startOfMonth()->toDateString();
        $toDate = $request->query('tDate') ?? now()->endOfMonth()->toDateString();

        // Ensure the toDate covers the full day
        $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

        $employee_payments = DB::table('employee_transactions')
            ->where('trans_type', 'Payment')
            ->whereBetween('employee_transactions.created_at', [$fromDate, $toDate])
            ->get();

        // Return the view
        return view('admin.summary_page', compact('fromDate', 'toDate', 'employee_payments'));
    }
    public function employee_return_summary(Request $request)
    {
        // Retrieve or set default dates
        $fromDate = $request->query('fDate') ?? now()->startOfMonth()->toDateString();
        $toDate = $request->query('tDate') ?? now()->endOfMonth()->toDateString();

        // Ensure the toDate covers the full day
        $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

        $employee_returns = DB::table('employee_transactions')
            ->where('trans_type', 'Return')
            ->whereBetween('employee_transactions.created_at', [$fromDate, $toDate])
            ->get();

        // Return the view
        return view('admin.summary_page', compact('fromDate', 'toDate', 'employee_returns'));
    }

    // Product Sales Reports Functions
    public function product_sale_report()
    {
        $sales = collect();
        $products = Product::all();
        $customers = Customer::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $users = PosUser::all();

        return view('admin.product_sale_summary', compact('sales', 'products', 'customers', 'categories', 'subcategories', 'brands', 'users'));
    }
    public function searchProductReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $sales = DB::table('sales')
            ->leftJoin('products', 'sales.product_id', '=', 'products.id')
            ->leftJoin('sale_details', 'sales.sales_ID', '=', 'sale_details.id')
            ->leftJoin('customers', 'sale_details.customerID', '=', 'customers.id')
            ->select(
                'sales.*',
                'products.title as product_name',
                'products.category as product_cat',
                'products.sub_category as product_sub_cat',
                'products.brand as product_brand',
                'products.supplier as product_supplier',
                'sale_details.invoiceNo as sales_invoice',
                'customers.name as customer_name'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('sales.created_at', [$fromDate, $toDate]);
            })
            ->when($request->productID, function ($query) use ($request) {
                $query->where('products.id', $request->productID);
            })
            ->when($request->batchNo, function ($query) use ($request) {
                $query->where('sales.batch_no', $request->batchNo);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->where('products.category', $request->category);
            })
            ->when($request->subcategory, function ($query) use ($request) {
                $query->where('products.sub_category', $request->subcategory);
            })
            ->when($request->brand, function ($query) use ($request) {
                $query->where('products.brand', $request->brand);
            })
            ->when($request->customerID, function ($query) use ($request) {
                $query->where('sale_details.customerID', $request->customerID);
            })
            ->when($request->supplier, function ($query) use ($request) {
                $query->where('products.supplier', $request->supplier);
            })
            ->when($request->user, function ($query) use ($request) {
                $query->where('sale_details.user', $request->user);
            })
            ->get();

        // Additional data
        $products = Product::all();
        $customers = Customer::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $users = PosUser::all();

        // Return the view
        return view('admin.product_sale_summary', compact('sales', 'products', 'customers', 'categories', 'subcategories', 'brands', 'users', 'fromDate', 'toDate'));
    }

    // Stock In Summary Functions
    public function sale_return_report()
    {
        $saleReturns = collect();
        $products = Product::all();
        $brands = Brand::all();

        return view('admin.sale_return_report', compact('saleReturns', 'products', 'brands'));
    }
    public function searchSaleReturnReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $saleReturns = DB::table('sale_returns')
            ->leftJoin('products', 'sale_returns.product_id', '=', 'products.id')
            ->leftJoin('sale_details', 'sale_returns.sales_ID', '=', 'sale_details.id')
            ->leftJoin('customers', 'sale_details.customerID', '=', 'customers.id')
            ->select(
                'sale_returns.*',
                'products.title as product_name',
                'products.barcode as product_code',
                'products.brand as product_brand',
                'customers.name as customer_name'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('sale_returns.created_at', [$fromDate, $toDate]);
            })
            ->when($request->productID, function ($query) use ($request) {
                $query->where('products.id', $request->productID);
            })
            ->when($request->batchNo, function ($query) use ($request) {
                $query->where('sale_returns.batch_no', $request->batchNo);
            })
            ->when($request->brand, function ($query) use ($request) {
                $query->where('products.brand', $request->brand);
            })
            ->when($request->invoiceNo, function ($query) use ($request) {
                $query->where('sale_returns.invoice_no', $request->invoiceNo);
            })
            ->when($request->customerID, function ($query) use ($request) {
                $query->where('sale_details.customerID', $request->customerID);
            })
            ->get();

        // Additional data
        $products = Product::all();
        $brands = Brand::all();

        // Return the view
        return view('admin.sale_return_report', compact('saleReturns', 'products', 'brands', 'fromDate', 'toDate'));
    }

    // Employee Transaction Reports Functions
    public function employee_trans_report()
    {
        $transactions = collect();
        $users = PosUser::all();

        return view('admin.employee_trans_report', compact('transactions', 'users'));
    }
    public function employeeTransReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $transactions = DB::table('employee_transactions')
            ->leftJoin('accounts', 'employee_transactions.account', '=', 'accounts.id')
            ->select(
                'employee_transactions.*',
                'accounts.acc_name as account_name'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('employee_transactions.created_at', [$fromDate, $toDate]);
            })
            ->when($request->employee, function ($query) use ($request) {
                $query->where('employee_transactions.employee', $request->employee);
            })
            ->when($request->trans_type, function ($query) use ($request) {
                $query->where('employee_transactions.trans_type', $request->trans_type);
            })
            ->get();

        // Additional data
        $users = PosUser::all();

        // Return the view
        return view('admin.employee_trans_report', compact('transactions', 'users', 'fromDate', 'toDate'));
    }

    // Office Transaction Reports Functions
    public function office_trans_report()
    {
        $transactions = collect();
        $categories = ExpenseCategory::all();

        return view('admin.office_trans_report', compact('transactions', 'categories'));
    }
    public function officeTransReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $transactions = DB::table('office_transactions')
            ->leftJoin('accounts', 'office_transactions.account', '=', 'accounts.id')
            ->select(
                'office_transactions.*',
                'accounts.acc_name as account_name'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('office_transactions.created_at', [$fromDate, $toDate]);
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('office_transactions.type', $request->type);
            })
            ->when($request->exp_type, function ($query) use ($request) {
                $query->where('office_transactions.exp_type', $request->exp_type);
            })
            ->get();

        // Additional data
        $categories = ExpenseCategory::all();

        // Return the view
        return view('admin.office_trans_report', compact('transactions', 'categories', 'fromDate', 'toDate'));
    }

    // Supplier Transaction Reports Functions
    public function supplier_trans_report()
    {
        $transactions = collect();

        return view('admin.supplier_trans_report', compact('transactions'));
    }
    public function supplierTransReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $transactions = DB::table('supplier_transactions')
            ->leftJoin('accounts', 'supplier_transactions.account', '=', 'accounts.id')
            ->leftJoin('suppliers', 'supplier_transactions.supplierID', '=', 'suppliers.id')
            ->select(
                'supplier_transactions.*',
                'accounts.acc_name as account_name',
                'suppliers.supplier_name as supplier_name'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('supplier_transactions.created_at', [$fromDate, $toDate]);
            })
            ->when($request->supplierID, function ($query) use ($request) {
                $query->where('supplier_transactions.supplierID', $request->supplierID);
            })
            ->get();


        // Return the view
        return view('admin.supplier_trans_report', compact('transactions', 'fromDate', 'toDate'));
    }

    // Stock Reports Functions
    public function stock_report()
    {
        $stocks = collect();
        $products = Product::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        return view('admin.stock_report', compact('stocks', 'products', 'categories', 'subcategories', 'brands'));
    }
    public function searchStockReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $stocks = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->select(
                'stocks.*',
                'products.title as product_name',
                'products.barcode as product_code',
                'products.category as product_cat',
                'products.sub_category as product_sub_cat',
                'products.brand as product_brand'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('stocks.created_at', [$fromDate, $toDate]);
            })
            ->when($request->productID, function ($query) use ($request) {
                $query->where('products.id', $request->productID);
            })
            ->when($request->batchNo, function ($query) use ($request) {
                $query->where('stocks.batch_no', $request->batchNo);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->where('products.category', $request->category);
            })
            ->when($request->subcategory, function ($query) use ($request) {
                $query->where('products.sub_category', $request->subcategory);
            })
            ->when($request->brand, function ($query) use ($request) {
                $query->where('products.brand', $request->brand);
            })
            ->when($request->supplier, function ($query) use ($request) {
                $query->where('stocks.supplier', $request->supplier);
            })
            ->get();

        // Additional data
        $products = Product::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        // Return the view
        return view('admin.stock_report', compact('stocks', 'products', 'categories', 'subcategories', 'brands', 'fromDate', 'toDate'));
    }

    // Stock In Summary Functions
    public function stockIn_summary()
    {
        $stockIns = collect();
        $products = Product::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        return view('admin.stockIn_summary', compact('stockIns', 'products', 'categories', 'subcategories', 'brands'));
    }
    public function searchStockInSum(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $stockIns = DB::table('stock_ins')
            ->leftJoin('products', 'stock_ins.product_id', '=', 'products.id')
            ->leftJoin('stock_details', 'stock_ins.batch_no', '=', 'stock_details.id')
            ->select(
                'stock_ins.*',
                'products.title as product_name',
                'products.barcode as product_code',
                'products.category as product_cat',
                'products.sub_category as product_sub_cat',
                'products.brand as product_brand',
                'stock_details.stock_date as stock_date',
                'stock_details.stock_note as stock_note'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('stock_ins.created_at', [$fromDate, $toDate]);
            })
            ->when($request->productID, function ($query) use ($request) {
                $query->where('products.id', $request->productID);
            })
            ->when($request->batchNo, function ($query) use ($request) {
                $query->where('stock_ins.batch_no', $request->batchNo);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->where('products.category', $request->category);
            })
            ->when($request->subcategory, function ($query) use ($request) {
                $query->where('products.sub_category', $request->subcategory);
            })
            ->when($request->brand, function ($query) use ($request) {
                $query->where('products.brand', $request->brand);
            })
            ->when($request->supplier, function ($query) use ($request) {
                $query->where('stock_ins.supplier', $request->supplier);
            })
            ->get();

        // Additional data
        $products = Product::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        // Return the view
        return view('admin.stockIn_summary', compact('stockIns', 'products', 'categories', 'subcategories', 'brands', 'fromDate', 'toDate'));
    }

    // Stock Out Report Functions
    public function stockOut_report()
    {
        $stockOuts = collect();
        $products = Product::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        return view('admin.stockOut_report', compact('stockOuts', 'products', 'categories', 'subcategories', 'brands'));
    }
    public function searchStockOutReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $stockOuts = DB::table('stock_outs')
            ->leftJoin('products', 'stock_outs.product_id', '=', 'products.id')
            ->leftJoin('stock_out_details', 'stock_outs.detailID', '=', 'stock_out_details.id')
            ->select(
                'stock_outs.*',
                'products.title as product_name',
                'products.barcode as product_code',
                'products.category as product_cat',
                'products.sub_category as product_sub_cat',
                'products.brand as product_brand',
                'stock_out_details.stock_date as stockOut_date',
                'stock_out_details.stock_note as stock_note'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('stock_outs.created_at', [$fromDate, $toDate]);
            })
            ->when($request->productID, function ($query) use ($request) {
                $query->where('products.id', $request->productID);
            })
            ->when($request->batchNo, function ($query) use ($request) {
                $query->where('stock_outs.batch_no', $request->batchNo);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->where('products.category', $request->category);
            })
            ->when($request->subcategory, function ($query) use ($request) {
                $query->where('products.sub_category', $request->subcategory);
            })
            ->when($request->brand, function ($query) use ($request) {
                $query->where('products.brand', $request->brand);
            })
            ->when($request->supplier, function ($query) use ($request) {
                $query->where('stock_outs.supplier', $request->supplier);
            })
            ->get();

        // Additional data
        $products = Product::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        // Return the view
        return view('admin.stockOut_report', compact('stockOuts', 'products', 'categories', 'subcategories', 'brands', 'fromDate', 'toDate'));
    }

    // Fund Transfer Reports Functions
    public function fund_transfer_report()
    {
        $transfers = collect();
        $users = PosUser::all();
        $accounts = Account::all();

        return view('admin.fund_transfer_report', compact('transfers', 'users', 'accounts'));
    }
    public function fundTransferReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $transfers = DB::table('fund_transfers')
            ->select(
                'fund_transfers.*',
                'account_from.acc_name as account_from_name',
                'account_from.acc_no as account_from_no',
                'account_to.acc_name as account_to_name',
                'account_to.acc_no as account_to_no'
            )
            ->join('accounts as account_from', 'fund_transfers.accountFrom', '=', 'account_from.id')
            ->join('accounts as account_to', 'fund_transfers.accountTo', '=', 'account_to.id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('fund_transfers.created_at', [$fromDate, $toDate]);
            })
            ->when($request->accountFrom, function ($query) use ($request) {
                $query->where('fund_transfers.accountFrom', $request->accountFrom);
            })
            ->when($request->accountTo, function ($query) use ($request) {
                $query->where('fund_transfers.accountTo', $request->accountTo);
            })
            ->when($request->user, function ($query) use ($request) {
                $query->where('fund_transfers.user', $request->user);
            })
            ->get();

        $users = PosUser::all();
        $accounts = Account::all();

        // Return the view
        return view('admin.fund_transfer_report', compact('transfers', 'users', 'accounts', 'fromDate', 'toDate'));
    }

    // Customer Ledger Reports Functions
    public function customer_ledger_report()
    {
        $transactions = collect();

        return view('admin.customer_ledger_report', compact('transactions'));
    }
    public function customerLedgerReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

        $transactions = DB::table('sale_details')
            ->leftJoin('customer_transactions', 'sale_details.customerID', '=', 'customer_transactions.customerID')
            ->leftJoin('customers', 'sale_details.customerID', '=', 'customers.id')
            ->leftJoin('accounts', 'customer_transactions.account', '=', 'accounts.id')
            ->select(
                'sale_details.id as sale_id',
                'sale_details.invoiceNo',
                'sale_details.cashDue',
                'sale_details.created_at as sale_date',
                'customer_transactions.id as transaction_id',
                'customer_transactions.account',
                'customer_transactions.amt_paid',
                'customer_transactions.created_at as transaction_date',
                'customers.due',
                'accounts.acc_name as account_name'
            )
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('sale_details.created_at', [$fromDate, $toDate]);
            })
            ->when($request->customerID, function ($query) use ($request) {
                $query->where('sale_details.customerID', $request->customerID);
            })
            ->where('sale_details.cashDue', '>', 0) // Filter entries with dues
            ->orderBy('sale_details.created_at')
            ->get();

        // Calculate total dues
        $totalDues = DB::table('sale_details')
            ->where('customerID', $request->customerID)
            ->sum('cashDue');

        // Calculate total paid amounts
        $totalPaid = DB::table('customer_transactions')
            ->where('customerID', $request->customerID)
            ->sum('amt_paid');

        // Fetch the customer's due amount
        $customerDue = DB::table('customers')
            ->where('id', $request->customerID)
            ->value('due');

        $fakeDue = $totalDues - $totalPaid;

        // Calculate the settled amount
        $settled = $fakeDue - $customerDue;

        $actualDue = $totalDues - $settled - $totalPaid;

        // Pass data to the view
        return view('admin.customer_ledger_report', compact('transactions', 'fromDate', 'toDate', 'settled', 'actualDue'));
    }
}
