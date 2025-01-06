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
        return view('admin.sales_list', compact('sale_details', 'customers', 'customer_types', 'users', 'sales'));
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

    // Sales Reports Functions
    public function priduct_sale_report()
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
                'sale_details.user as sales_invoice',
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
}
