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

class AdminController extends Controller
{
    // Users functions ------------------------------------------>
    public function user_info() {
        $pos_users = PosUser::all();
        return view('admin.pos_user', compact('pos_users'));
    }
    public function add_user(Request $request) {
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|max:30',
            'phone' => 'required|string|max:30',
        ]);

        $data = new PosUser;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->job_title = $request->job_title;
        $data->dob = $request->dob;
        $data->jod = $request->jod;
        $data->salary = $request->salary;
        $data->nid = $request->nid;
        $data->blood_group = $request->blood_group;
        $data->address = $request->address;
        // $data->type = $request->type;

        $image = $request->image;
        if ($image) {
            $imagename = time(). '.' .$image->getClientOriginalExtension();
            $request->image->move('users', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('User added successfully!');
        return redirect()->back();
    }
    public function edit_user(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|max:30',
            'phone' => 'required|string|max:30',
        ]);

        $data = PosUser::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->job_title = $request->job_title;
        $data->dob = $request->dob;
        $data->jod = $request->jod;
        $data->salary = $request->salary;
        $data->nid = $request->nid;
        $data->blood_group = $request->blood_group;
        $data->address = $request->address;
        // $data->type = $request->type;

        $image = $request->image;
        if ($image) {
            if ($data->image && file_exists(public_path('users/' . $data->image))) {
                unlink(public_path('users/' . $data->image));
            }

            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('users', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('User info updated successfully!');
        return redirect('/user_info');
    }
    public function delete_user($id) {
        $data = PosUser::find($id);

        // Check if there is an image before trying to delete it
        if ($data->image) {
            $image_path = public_path('users/' . $data->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('User deleted successfully!');
        return redirect()->back();
    }


    // Customers functions ------------------------------------------>
    public function customer_info() {
        $customers = Customer::all();
        $customer_types = CustomerType::all();
        return view('admin.customer', compact('customers', 'customer_types'));
    }
    public function add_customer(Request $request) {
        $data = new Customer;
        $data->member_code = $request->member_code;
        $data->type = $request->c_type;
        $data->name = $request->c_name;
        $data->email = $request->c_email;
        $data->phone = $request->c_phone;
        $data->gender = $request->c_gender;
        $data->dob = $request->dob;
        $data->merital_st = $request->m_status;
        $data->anv_date = $request->anniversary;
        $data->adrs_type = $request->adrs_type;
        $data->address = $request->address;
        $data->due = 0;

        $image = $request->image;
        if ($image) {
            $imagename = time(). '.' .$image->getClientOriginalExtension();
            $request->image->move('customers', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Customer added successfully!');
        return redirect()->back();
    }
    public function edit_customer(Request $request, $id) {
        $data = Customer::find($id);
        $data->member_code = $request->member_code;
        $data->type = $request->c_type;
        $data->name = $request->c_name;
        $data->email = $request->c_email;
        $data->phone = $request->c_phone;
        $data->gender = $request->c_gender;
        $data->dob = $request->dob;
        $data->merital_st = $request->m_status;
        $data->anv_date = $request->anniversary;
        $data->adrs_type = $request->adrs_type;
        $data->address = $request->address;

        $image = $request->image;
        if ($image) {
            if ($data->image && file_exists(public_path('customers/' . $data->image))) {
                unlink(public_path('customers/' . $data->image));
            }

            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('customers', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Customer info updated successfully!');
        return redirect('/customer_info');
    }
    public function delete_customer($id) {
        $data = Customer::find($id);

        // Check if there is an image before trying to delete it
        if ($data->image) {
            $image_path = public_path('customers/' . $data->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Customer deleted successfully!');
        return redirect()->back();
    }

    public function customer_type() {
        $customer_types = CustomerType::all();
        return view('admin.customer_type', compact('customer_types'));
    }
    public function add_customer_type(Request $request) {
        $data = new CustomerType;
        $data->type_name = $request->cus_type;
        $data->discount = $request->dis_amt ?? 0.00;
        $data->target_sale = $request->tgt_sale ?? 0.00;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Customer Type added successfully!');
        return redirect()->back();
    }
    public function edit_customer_type(Request $request, $id) {
        $data = CustomerType::find($id);
        $data->type_name = $request->cus_type;
        $data->discount = $request->dis_amt ?? 0.00;
        $data->target_sale = $request->tgt_sale ?? 0.00;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Customer type updated successfully!');
        return redirect('/customer_type');
    }
    public function delete_customer_type($id) {
        $data = CustomerType::find($id);

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Customer Type deleted successfully!');
        return redirect()->back();
    }

    // Customers functions ------------------------------------------>
    public function supplier_info() {
        $suppliers = Supplier::all();
        return view('admin.suppliers', compact('suppliers'));
    }
    public function add_supplier(Request $request) {
        $data = new Supplier;
        $data->supplier_code = $request->supplier_code;
        $data->supplier_name = $request->name;
        $data->contact_person = $request->contact;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vat_reg_num = $request->vat_reg;
        $data->note = $request->note;

        $image = $request->image;
        if ($image) {
            $imagename = time(). '.' .$image->getClientOriginalExtension();
            $request->image->move('suppliers', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Supplier added successfully!');
        return redirect()->back();
    }
    public function edit_supplier(Request $request, $id) {
        $data = Supplier::find($id);
        $data->supplier_code = $request->supplier_code;
        $data->supplier_name = $request->name;
        $data->contact_person = $request->contact;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vat_reg_num = $request->vat_reg;
        $data->note = $request->note;

        $image = $request->image;
        if ($image) {
            if ($data->image && file_exists(public_path('suppliers/' . $data->image))) {
                unlink(public_path('suppliers/' . $data->image));
            }

            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('suppliers', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Supplier info updated successfully!');
        return redirect('/supplier_info');
    }
    public function delete_supplier($id) {
        $data = Supplier::find($id);

        // Check if there is an image before trying to delete it
        if ($data->image) {
            $image_path = public_path('suppliers/' . $data->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Customer deleted successfully!');
        return redirect()->back();
    }


    // Categories/Sub Categories/Brands functions ------------------------------------------>
    public function classifications() {
        $datas = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $units = Unit::all();
        return view('admin.classification', compact('datas', 'subcategories', 'brands', 'units'));
    }

    public function add_category(Request $request) {
        $request->validate([
            'category' => 'required|string|max:25',
        ]);

        $data = new Category();
        $data->category_name = $request->category;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Category added successfully!');
        return redirect()->back();
    }
    public function update_category(Request $request, $id) {
        $request->validate([
            'e_category' => 'required|string|max:25',
        ]);

        $data = Category::find($id);

        $data->category_name = $request->e_category;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Category updated successfully!');
        return redirect('/classifications');
    }
    public function delete_category($id) {
        $data = Category::find($id);

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Category deleted successfully!');
        return redirect()->back();
    }

    public function add_sub_category(Request $request) {
        $request->validate([
            'sub_category' => 'required|string|max:25',
            'category' => 'required|string|max:25',
        ]);

        $data = new Subcategory();
        $data->sub_category = $request->sub_category;
        $data->category = $request->category;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Sub Category added successfully!');
        return redirect()->back();
    }
    public function update_sub_category(Request $request, $id) {
        $request->validate([
            'sub_category' => 'required|string|max:25',
            'category' => 'required|string|max:25',
        ]);

        $data = Subcategory::find($id);

        $data->sub_category = $request->sub_category;
        $data->category = $request->category;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Sub category updated successfully!');
        return redirect('/classifications');
    }
    public function delete_sub_category($id) {
        $data = Subcategory::find($id);

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Sub Category deleted successfully!');
        return redirect()->back();
    }

    public function add_brand(Request $request) {
        $request->validate([
            'brand_name' => 'required|string|max:25',
        ]);

        $incomingData = new Brand();
        $incomingData->brand_name = $request->brand_name;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Brand added successfully!');
        return redirect()->back();
    }
    public function update_brand(Request $request, $id) {
        $request->validate([
            'brand_name' => 'required|string|max:25',
        ]);

        $data = Brand::find($id);

        $data->brand_name = $request->brand_name;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Brand updated successfully!');
        return redirect('/classifications');
    }
    public function delete_brand($id) {
        $data = Brand::find($id);

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Brand deleted successfully!');
        return redirect()->back();
    }

    public function add_unit(Request $request) {
        $request->validate([
            'unit' => 'required|string|max:25',
        ]);

        $Data = new Unit();
        $Data->unit = $request->unit;

        $Data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Unit added successfully!');
        return redirect()->back();
    }
    public function update_unit(Request $request, $id) {
        $request->validate([
            'unit' => 'required|string|max:25',
        ]);

        $data = Unit::find($id);

        $data->unit = $request->unit;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Unit updated successfully!');
        return redirect('/classifications');
    }
    public function delete_unit($id) {
        $data = Unit::find($id);

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Unit deleted successfully!');
        return redirect()->back();
    }


    // All Product functions ------------------------------------------------------------------->
    public function view_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $units = Unit::all();

        // Join Product and Stock tables with aggregated quantity and paginate
        $products = Product::leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
            ->select(
                'products.*',
                DB::raw('GROUP_CONCAT(stocks.batch_no SEPARATOR ", ") as batch_numbers'), // Concatenate batch numbers
                DB::raw('SUM(stocks.quantity) as total_quantity') // Sum quantities for each product
            )
            ->groupBy('products.id') // Group by product ID
            ->paginate(5); // Add pagination here

        // Fetch all product batches without pagination
        $product_batches = Stock::join('products', 'stocks.product_id', '=', 'products.id')
            ->join('stock_details', 'stocks.batch_no', '=', 'stock_details.id') // Join with StockDetail table
            ->select(
                'stocks.product_id',
                'stocks.product_name',
                'stocks.batch_no',
                'stocks.supplier',
                'stocks.quantity',
                'stocks.sale_price',
                'stocks.expiration_date',
                'stock_details.stock_date' // Replace with actual column names from StockDetail
            )
            ->orderBy('stocks.product_id') // Sort by product for easier grouping
            ->get();

        return view('admin.view_product', compact(
            'categories', 'subcategories', 'brands', 'units', 'products', 'product_batches'
        ));
    }

    public function searchProduct(Request $request)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $units = Unit::all();

        $products = Product::leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
            ->select(
                'products.*',
                DB::raw('GROUP_CONCAT(stocks.batch_no SEPARATOR ", ") as batch_numbers'),
                DB::raw('SUM(stocks.quantity) as total_quantity')
            )
            ->groupBy('products.id')
            ->when($request->product, function ($query) use ($request) {
                $query->where('products.title', 'LIKE', '%' . $request->product . '%');
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
            ->paginate(5);

            // Fetch all product batches with details, including data from StockDetail table
        $product_batches = Stock::join('products', 'stocks.product_id', '=', 'products.id')
            ->join('stock_details', 'stocks.batch_no', '=', 'stock_details.id')  // Join with StockDetail table
            ->select(
                'stocks.product_id',
                'stocks.product_name',
                'stocks.batch_no',
                'stocks.supplier',
                'stocks.quantity',
                'stocks.sale_price',
                'stocks.expiration_date',
                'stock_details.stock_date' // Replace with actual column names from StockDetail
            )
            ->orderBy('stocks.product_id') // Sort by product for easier grouping
            ->get();

        // Return the view
        return view('admin.view_product', compact('categories', 'subcategories', 'brands', 'units', 'products', 'product_batches'));
    }
    public function upload_product(Request $request) {
        $data = new Product;
        $data->barcode = $request->barcode;
        $data->title = $request->title;
        $data->category = $request->category;
        $data->sub_category = $request->sub_category;
        $data->brand = $request->brand;
        $data->unit = $request->unit;
        $data->b_price = $request->b_price;
        $data->s_price = $request->s_price ?? 0;
        $data->vatable = $request->has('vatable') ? 'yes' : 'no';
        $data->min_s = $request->min_s ?? 0;
        $data->max_s = $request->max_s ?? 0;
        $data->supplier = $request->supplier;

        $image = $request->image;
        if ($image) {
            $imagename = time(). '.' .$image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product added successfully!');
        return redirect()->back();
    }
    public function edit_products(Request $request, $id) {
        $data = Product::find($id);
        $data->barcode = $request->barcode;
        $data->title = $request->title;
        $data->category = $request->edit_category;
        $data->sub_category = $request->edit_sub_category;
        $data->brand = $request->brand;
        $data->unit = $request->unit;
        $data->b_price = $request->b_price;
        $data->s_price = $request->s_price ?? 0;
        $data->vatable = $request->has('vatable') ? 'yes' : 'no';
        $data->min_s = $request->min_s ?? 0;
        $data->max_s = $request->max_s ?? 0;
        $data->supplier = $request->supplier;

        $image = $request->image;
        if ($image) {
            // Check if there's an existing image and unlink it
            if ($data->image && file_exists(public_path('products/' . $data->image))) {
                unlink(public_path('products/' . $data->image));
            }

            // Save the new image
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product updated successfully!');
        return redirect('/view_product');
    }
    public function delete_product($id) {
        $data = Product::find($id);

        // Check if there is an image before trying to delete it
        if ($data->image) {
            $image_path = public_path('products/' . $data->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product deleted successfully!');
        return redirect()->back();
    }


    // Stock In functions --------------------------------->
    public function stock_in_list() {
        $stock_details = StockDetail::all();
        return view('admin.stock_in_list', compact('stock_details'));
    }
    public function invoice_details($id) {
        $invoice = StockDetail::find($id);
        $products = StockIn::where('batch_no', $id)
        ->join('products', 'stock_ins.product_id', '=', 'products.id')  // Assuming 'product_id' in Stock and 'id' in Product
        ->select('products.*', 'stock_ins.*')  // Select all columns from both Stock and Product tables
        ->get();
        return view('admin.invoice_detail', compact('invoice', 'products'));
    }
    public function add_stock() {
        $products = Product::all();
        return view('admin.add_stock', compact('products'));
    }
    public function stock_search(Request $request)
    {
        $search = $request->input('query');
        $products = Product::where('title', 'LIKE', "%{$search}%")
                            ->orWhere('barcode', 'LIKE', "%{$search}%")
                            ->get(['id', 'title']); // Fetch both 'id' and 'title'

        return response()->json($products);
    }
    public function getNextStockInvoice()
    {
        $lastInvoice = DB::table('stock_details')
            ->orderBy('id', 'desc') // Assuming 'id' is the primary key or auto-increment column
            ->value('stock_invoice'); // Fetch the latest stock_invoice value

        $nextInvoice = $lastInvoice ? $lastInvoice + 1 : 1; // Increment or set to 1 if no records exist
        return response()->json(['next_invoice' => $nextInvoice]);
    }
    public function saveStock(Request $request)
    {
        try {
            // Extract the hidden stock form data
            $stockDate = $request->stock_date;
            $image = $request->file('image');
            $stockInvoice = $request->stock_invoice;
            $stockNote = $request->stock_note ?? 'N/A';

            if ($image) {
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move('uploads', $imagename);
            } else {
                $imagename = null;
            }

            // Insert stock details into the stock_details table
            $stockDetailId = DB::table('stock_details')->insertGetId([
                'user' => Auth::user()->name,
                'stock_date' => $stockDate,
                'image_path' => $imagename,
                'stock_invoice' => $stockInvoice,
                'stock_note' => $stockNote,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Process each row of stock data and store it in the stocks table
            $rows = json_decode($request->rows, true); // Decode the rows from JSON to array

            foreach ($rows as $row) {
                DB::table('stocks')->insert([
                    'batch_no' => $stockDetailId,
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'supplier' => $row['supplier'],
                    'rack_id' => $row['rackID'],
                    'quantity' => $row['quantity'],
                    'expiration_date' => $row['expiration_date'],
                    'alert_date' => $row['alert_date'],
                    'purchase_price' => $row['purchase_price'],
                    'sale_price' => $row['sale_price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('stock_ins')->insert([
                    'batch_no' => $stockDetailId,
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'supplier' => $row['supplier'],
                    'rack_id' => $row['rackID'],
                    'quantity' => $row['quantity'],
                    'expiration_date' => $row['expiration_date'],
                    'alert_date' => $row['alert_date'],
                    'purchase_price' => $row['purchase_price'],
                    'sale_price' => $row['sale_price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Show success toastr message
            toastr()->timeOut(5000)->closeButton()->addSuccess('Stock saved successfully!');
            return redirect()->back();

        } catch (\Exception $e) {
            // Show error toastr message
            toastr()->timeOut(5000)->closeButton()->addError('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    // All Stock_out functions --------------------------------->
    public function stock_out_list() {
        $stock_out_details = StockOutDetail::all();
        return view('admin.stock_out_list', compact('stock_out_details'));
    }
    public function invoice_so_details($id) {
        $invoice = StockOutDetail::find($id);
        $products = StockOut::where('detailID', $id)
        ->join('products', 'stock_outs.product_id', '=', 'products.id')
        ->select('products.*', 'stock_outs.*')
        ->get();
        return view('admin.invoice_so_details', compact('invoice', 'products'));
    }
    public function stock_out() {
        $products = Product::all();
        $stocks = Stock::all();
        return view('admin.stock_out', compact('products', 'stocks'));
    }
    public function getProductBatches(Request $request)
    {
        $productName = $request->input('product_name');

        // Fetch batches matching the product name
        $batches = DB::table('stocks')
            ->whereRaw('TRIM(LOWER(product_name)) = ?', [trim(strtolower($productName))])
            ->select('id', 'batch_no') // Include id
            ->distinct()
            ->get();

        return response()->json($batches);
    }
    public function getBatchDetails(Request $request)
    {
        $batchId = $request->input('batch_id');

        // Fetch batch details using the id
        $details = DB::table('stocks')
            ->where('id', $batchId) // Match the id
            ->select('supplier', 'quantity', 'expiration_date')
            ->first();

        return response()->json($details);
    }
    public function getNextStockOutInvoice()
    {
        $lastInvoice = DB::table('stock_out_details')
            ->orderBy('id', 'desc')
            ->value('stock_invoice');

        $nextInvoice = $lastInvoice ? $lastInvoice + 1 : 1;
        return response()->json(['next_invoice' => $nextInvoice]);
    }
    public function saveStockOut(Request $request){
        try {
            // Extract the hidden stock form data
            $stockDate = $request->stock_date;
            $image = $request->file('image');
            $stockInvoice = $request->stock_invoice;
            $stockNote = $request->stock_note ?? 'N/A';

            if ($image) {
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move('uploads', $imagename);
            } else {
                $imagename = null;
            }

            // Insert stock details into the stock_out_details table
            $stockOutDetailId = DB::table('stock_out_details')->insertGetId([
                'user' => Auth::user()->name,
                'stock_date' => $stockDate,
                'image_path' => $imagename,
                'stock_invoice' => $stockInvoice,
                'stock_note' => $stockNote,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Process each row of stock data and store it in the stock_outs table
            $rows = json_decode($request->rows, true);

            foreach ($rows as $row) {
                // Insert into stock_outs table
                DB::table('stock_outs')->insert([
                    'detailID' => $stockOutDetailId,
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'supplier' => $row['supplier'],
                    'quantity' => $row['quantity'],
                    'purchase_price' => $row['purchase_price'],
                    'sale_price' => $row['sale_price'],
                    'rack_id' => $row['rack_id'],
                    'expiration_date' => $row['expiration_date'],
                    'batch_no' => $row['batch_no'],
                    'so_qty' => $row['so_qty'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update the stocks table to decrease the quantity
                DB::table('stocks')
                ->where('product_id', $row['product_id'])
                ->where('batch_no', $row['batch_no'])
                ->decrement('quantity', $row['so_qty']);

                // Check if the stock quantity is zero and delete the row if it is
                $stock = DB::table('stocks')
                ->where('product_id', $row['product_id'])
                ->where('batch_no', $row['batch_no'])
                ->first();

                if ($stock && $stock->quantity == 0) {
                DB::table('stocks')
                    ->where('product_id', $row['product_id'])
                    ->where('batch_no', $row['batch_no'])
                    ->delete();
                }
            }

            // Show success toastr message
            toastr()->timeOut(5000)->closeButton()->addSuccess('Stock Out has been successful!');
            return redirect()->back();

        } catch (\Exception $e) {
            // Show error toastr message
            toastr()->timeOut(5000)->closeButton()->addError('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    // Sales related Function ----------------------------------------->
    public function sales() {
        $stocks = Stock::all();
        $heldSales = DB::table('hold_sales')
            ->selectRaw('invoiceNo, COUNT(*) as held_products, MAX(created_at) as date')
            ->groupBy('invoiceNo')
            ->get();
        $restoreSale = HoldSale::all();
        $accounts = Account::all();
        $cardnames = CardName::all();
        $sales = Sale::all();
        $sale_details = SaleDetail::all();
        $sale_returns = SaleReturn::all();
        return view('admin.sales', compact('stocks', 'heldSales', 'restoreSale', 'accounts', 'cardnames', 'sales', 'sale_details', 'sale_returns'));
    }
    public function sales_search(Request $request)
    {
        $search = $request->input('query');

        // Sort by batch_no in ascending order to get the oldest batch first
        $products = Product::join('stocks', 'products.id', '=', 'stocks.product_id')
            ->where('products.title', 'LIKE', "%{$search}%")
            ->orWhere('products.barcode', 'LIKE', "%{$search}%")
            ->select('products.title', 'products.barcode', 'stocks.batch_no')
            ->orderBy('stocks.batch_no', 'asc')  // Sort by batch_no ascending to get the oldest batch
            ->get();

        return response()->json($products);
    }
    public function customer_search(Request $request)
    {
        $query = $request->input('query');
        $customers = Customer::where('name', 'LIKE', "%{$query}%")
        ->orWhere('phone', 'LIKE', "%{$query}%")
        ->get();

        return response()->json($customers);
    }
    public function saveSales(Request $request){
        try {
            // Extract the hidden stock form data
            $user = Auth::user()->name;
            $invoiceNo = $request->invoice_no;
            $cashTotal = $request->cash_total;
            $cashDiscount = $request->cash_dis;
            $cashRound = $request->cash_round;
            $cashDue = $request->cash_due;
            $customer_id = $request->customerID ?? null;

            $cashAmount = $request->s_cash_amt > 0 ? $request->s_cash_amt : ($request->m_cash_amt > 0 ? $request->m_cash_amt : 0.00);
            $cashPaid = $request->s_cash_paid;
            $cashChange = $request->s_cash_change;

            $cardAmount = $request->s_card_amt > 0 ? $request->s_card_amt : ($request->m_card_amt > 0 ? $request->m_card_amt : 0.00);
            $cardNumber = $request->s_card_num ?? $request->m_card_num ?? null;
            $cardType = $request->s_card_type ?? $request->m_card_type ?? null;
            $bankType = $request->s_bank_type ?? $request->m_bank_type ?? null;

            $mobileAmount = $request->s_mob_amt > 0 ? $request->s_mob_amt : ($request->m_mob_amt > 0 ? $request->m_mob_amt : 0.00);
            $mobileBank = $request->s_mob_bank ?? $request->m_mob_bank ?? null;
            $mobileTrans = $request->s_mob_trans ?? $request->m_mob_trans ?? null;
            $mobileRcvno = $request->s_mob_rcv ?? null;

            $totalPaidAmount = ($cashAmount + $cardAmount + $mobileAmount);

            $customer = Customer::find($customer_id);
            if ($customer) {
                // Access customer details
                $customer_name = $customer->name;
                // $customer_phone = $customer->phone;
            } else {
                $customer_name = 'N/A';
            }

            // Insert stock details into the stock_out_details table
            $salesId = DB::table('sale_details')->insertGetId([
                'user' => $user,
                'invoiceNo' => $invoiceNo,
                'cashTotal' => $cashTotal,
                'cashDiscount' => $cashDiscount,
                'cashRound' => $cashRound,
                'cashDue' => $cashDue,
                'customerID' => $customer_id,
                'cashAmount' => $cashAmount,
                'cashPaid' => $cashPaid,
                'cashChange' => $cashChange,
                'cardAmount' => $cardAmount,
                'cardNumber' => $cardNumber,
                'cardType' => $cardType,
                'bankType' => $bankType,
                'mobileAmount' => $mobileAmount,
                'mobileBank' => $mobileBank,
                'mobileTrans' => $mobileTrans,
                'mobileRcvno' => $mobileRcvno,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($cashDue > 0) {
                DB::table('customers')
                    ->where('id', $customer_id)
                    ->increment('due', $cashDue);
            }

            DB::table('accounts')
                ->where('id', 4)
                ->increment('crnt_balance', $cashAmount);

            DB::table('accounts')
                ->where('id', $bankType)
                ->increment('crnt_balance', $cardAmount);

            DB::table('accounts')
                ->where('id', $mobileBank)
                ->increment('crnt_balance', $mobileAmount);

            // Process each row of stock data and store it in the stock_outs table
            $rows = json_decode($request->rows, true);
            $total_quantity = array_sum(array_column($rows, 'so_qty'));
            $total_price = array_sum(array_column($rows, 'total_price'));
            $row_count = count($rows);

            foreach ($rows as $row) {
                // Insert into stock_outs table
                DB::table('sales')->insert([
                    'sales_ID' => $salesId,
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'batch_no' => $row['batch_no'],
                    'so_qty' => $row['so_qty'],
                    'price' => $row['price'],
                    'total' => $row['total_price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update the stocks table to decrease the quantity
                DB::table('stocks')
                ->where('product_id', $row['product_id'])
                ->where('batch_no', $row['batch_no'])
                ->decrement('quantity', $row['so_qty']);

                // Check if the stock quantity is zero and delete the row if it is
                $stock = DB::table('stocks')
                ->where('product_id', $row['product_id'])
                ->where('batch_no', $row['batch_no'])
                ->first();

                if ($stock && $stock->quantity == 0) {
                DB::table('stocks')
                    ->where('product_id', $row['product_id'])
                    ->where('batch_no', $row['batch_no'])
                    ->delete();
                }
            }

            // Return JSON response with success message and data
            return response()->json([
                'success' => true,
                'message' => 'Sales added successfully!',
                'user' => $user,
                'customer_name' => $customer_name,
                'invoiceNo' => $invoiceNo,
                'rows' => $rows,
                'items' => $row_count,
                'total_qty' => $total_quantity,
                'total_price' => $total_price,
                'discount' => $cashDiscount,
                'cashTotal' => $cashTotal,
                'cashRound' => $cashRound,
                'cashDue' => $cashDue,
                'cashPaid' => $cashPaid,
                'cashChange' => $cashChange,
                'totalPaidAmt' => $totalPaidAmount,
                'cashAmount' => $cashAmount,
                'cardAmount' => $cardAmount,
                'mobileAmount' => $mobileAmount,
            ]);

        } catch (\Exception $e) {
            // Return JSON response with error message
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function holdSales(Request $request){
        try {
            $invoiceNo = $request->invoiceNo;

            // Process each row of stock data and store it in the hold_sale table
            $rows = json_decode($request->rows, true);

            foreach ($rows as $row) {
                // Insert into hold_sales table
                DB::table('hold_sales')->insert([
                    'invoiceNo' => $invoiceNo,
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'batch_no' => $row['batch_no'],
                    'so_qty' => $row['so_qty'],
                    'price' => $row['price'],
                    'total' => $row['total_price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            toastr()->timeOut(5000)->closeButton()->addSuccess('Sale held successfully!');
            return redirect()->back();

        } catch (\Exception $e) {
            toastr()->timeOut(5000)->closeButton()->addError('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    public function deleteHoldSale(Request $request)
    {
        $invoiceNo = $request->invoiceNo;

        HoldSale::where('invoiceNo', $invoiceNo)->delete();

        return response()->json(['message' => 'Sales Restored successfully.']);
    }
    public function sale_returns() {
        $sales = Sale::all();
        $sale_details = SaleDetail::all();
        $sale_returns = SaleReturn::all();
        return view('admin.sale_returns', compact('sales', 'sale_details', 'sale_returns'));
    }
    public function saveReturn(Request $request){
        try {
            $invoiceNo = $request->invoice_no;

            // Process each row of stock data and store it in the stock_outs table
            $rows = json_decode($request->rows, true);

            foreach ($rows as $row) {
                // Insert into stock_outs table
                DB::table('sale_returns')->insert([
                    'invoice_no' => $invoiceNo,
                    'sales_ID' => $row['sales_ID'],
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'batch_no' => $row['batch'],
                    'return_qty' => $row['return_qty'],
                    'price' => $row['price'],
                    'total' => $row['total_price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update the stocks table to increase the quantity
                DB::table('stocks')
                ->where('product_id', $row['product_id'])
                ->where('batch_no', $row['batch'])
                ->increment('quantity', $row['return_qty']);

                // Update the sales table to increase the returned qty
                DB::table('sales')
                ->where('sales_ID', $row['sales_ID'])
                ->where('product_id', $row['product_id'])
                ->where('batch_no', $row['batch'])
                ->update([
                    'returned' => DB::raw("IFNULL(returned, 0) + {$row['return_qty']}")
                ]);

                // Decrease amount from Primary Station
                DB::table('accounts')
                ->where('id', 4)
                ->decrement('crnt_balance', $row['total_price']);
            }

            toastr()->timeOut(5000)->closeButton()->addSuccess('Sale Return has been successful!');
            return redirect()->back();

        } catch (\Exception $e) {
            toastr()->timeOut(5000)->closeButton()->addError('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }


    // Account Settings related functions --------------------------------->
    public function banks_cards() {
        $banks = BankName::all();
        $cards = CardName::all();
        return view('admin.banks_&_cards', compact('banks', 'cards'));
    }
    public function add_bank(Request $request) {
        $request->validate([
            'bankName' => 'required|string|max:25',
        ]);

        $incomingData = new BankName();
        $incomingData->bank_name = $request->bankName;
        $incomingData->bank_type = $request->bankType;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Bank added successfully!');
        return redirect()->back();
    }
    public function update_bank(Request $request, $id) {
        $request->validate([
            'bankName' => 'required|string|max:25',
        ]);

        $data = BankName::find($id);

        $data->bank_name = $request->bankName;
        $data->bank_type = $request->bankType;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Bank updated successfully!');
        return redirect('/banks_cards');
    }
    public function delete_bank($id) {
        $data = BankName::find($id);

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Bank deleted successfully!');
        return redirect()->back();
    }
    public function add_card(Request $request) {
        $request->validate([
            'cardName' => 'required|string|max:25',
        ]);

        $incomingData = new CardName();
        $incomingData->card_name = $request->cardName;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Card added successfully!');
        return redirect()->back();
    }
    public function update_card(Request $request, $id) {
        $request->validate([
            'cardName' => 'required|string|max:25',
        ]);

        $data = CardName::find($id);

        $data->card_name = $request->cardName;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Card updated successfully!');
        return redirect('/banks_cards');
    }
    public function delete_card($id) {
        $data = CardName::find($id);

        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Card deleted successfully!');
        return redirect()->back();
    }

    public function accounts() {
        $accounts = Account::all();
        $banks = BankName::all();
        $cards = CardName::all();
        return view('admin.accounts', compact('accounts', 'banks', 'cards'));
    }
    public function add_bankAcc(Request $request) {
        $request->validate([
            'acc_uses' => 'required|string',
            'acc_name' => 'required|string',
            'acc_no' => 'required',
            'acc_branch' => 'required|string',
            'ini_balance' => 'required',
        ]);

        $incomingData = new Account();
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->acc_name = $request->acc_name;
        $incomingData->acc_no = $request->acc_no;
        $incomingData->acc_branch = $request->acc_branch;
        $incomingData->address = $request->address;
        $incomingData->description = $request->description;
        $incomingData->ini_balance = $request->ini_balance;
        $incomingData->crnt_balance = 0;
        $incomingData->account_type = 'Bank';

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Bank Account added successfully!');
        return redirect()->back();
    }
    public function update_bankAcc(Request $request, $id) {
        $request->validate([
            'acc_uses' => 'required|string',
        ]);

        $incomingData = Account::find($id);
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->address = $request->address;
        $incomingData->description = $request->description;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Bank Account updated successfully!');
        return redirect('/accounts');
    }
    public function delete_bankAcc($id) {

        $data = Account::find($id);
        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Bank Account deleted successfully!');
        return redirect()->back();
    }
    public function add_cashAcc(Request $request) {
        $request->validate([
            'acc_uses' => 'required|string',
            'acc_name' => 'required|string',
            'ini_balance' => 'required',
        ]);

        $incomingData = new Account();
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->acc_name = $request->acc_name;
        $incomingData->description = $request->description;
        $incomingData->ini_balance = $request->ini_balance;
        $incomingData->crnt_balance = 0;
        $incomingData->account_type = 'Cash';

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Cash Account added successfully!');
        return redirect()->back();
    }
    public function update_cashAcc(Request $request, $id) {
        $request->validate([
            'acc_uses' => 'required|string',
        ]);

        $incomingData = Account::find($id);
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->description = $request->description;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Cash Account updated successfully!');
        return redirect('/accounts');
    }
    public function delete_cashAcc($id) {

        $data = Account::find($id);
        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Cash Account deleted successfully!');
        return redirect()->back();
    }
    public function add_mobileAcc(Request $request) {
        $request->validate([
            'acc_uses' => 'required|string',
            'acc_name' => 'required|string',
            'acc_no' => 'required',
            'acc_type' => 'required|string',
            'trans_chrg' => 'required',
            'ini_balance' => 'required',
        ]);

        $incomingData = new Account();
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->acc_name = $request->acc_name;
        $incomingData->acc_no = $request->acc_no;
        $incomingData->mob_acc_type = $request->acc_type;
        $incomingData->trans_chrg = $request->trans_chrg;
        $incomingData->description = $request->description;
        $incomingData->ini_balance = $request->ini_balance;
        $incomingData->crnt_balance = 0;
        $incomingData->account_type = 'Mobile';

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Mobile Account added successfully!');
        return redirect()->back();
    }
    public function update_mobileAcc(Request $request, $id) {
        $request->validate([
            'acc_uses' => 'required|string',
            'acc_type' => 'required|string',
            'trans_chrg' => 'required',
        ]);

        $incomingData = Account::find($id);
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->mob_acc_type = $request->acc_type;
        $incomingData->trans_chrg = $request->trans_chrg;
        $incomingData->description = $request->description;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Mobile Account updated successfully!');
        return redirect('/accounts');
    }
    public function delete_mobileAcc($id) {

        $data = Account::find($id);
        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Mobile Account deleted successfully!');
        return redirect()->back();
    }
    public function add_stationAcc(Request $request) {
        $request->validate([
            'acc_uses' => 'required|string',
            'acc_name' => 'required|string',
            'ini_balance' => 'required',
        ]);

        $incomingData = new Account();
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->acc_name = $request->acc_name;
        $incomingData->description = $request->description;
        $incomingData->ini_balance = $request->ini_balance;
        $incomingData->crnt_balance = 0;
        $incomingData->account_type = 'Station';

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Station Account added successfully!');
        return redirect()->back();
    }
    public function update_stationAcc(Request $request, $id) {
        $request->validate([
            'acc_uses' => 'required|string',
        ]);

        $incomingData = Account::find($id);
        $incomingData->acc_uses = $request->acc_uses;
        $incomingData->description = $request->description;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Station Account updated successfully!');
        return redirect('/accounts');
    }
    public function delete_stationAcc($id) {

        $data = Account::find($id);
        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Station Account deleted successfully!');
        return redirect()->back();
    }

    public function expense_ctg() {
        $exp_ctgs = ExpenseCategory::all();
        return view('admin.expense_category', compact('exp_ctgs'));
    }
    public function add_trans_cat(Request $request) {
        $request->validate([
            'catName' => 'required|string',
            'catType' => 'required|string',
        ]);

        $incomingData = new ExpenseCategory();
        $incomingData->catName = $request->catName;
        $incomingData->catType = $request->catType;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Transaction category added successfully!');
        return redirect()->back();
    }
    public function update_trans_cat(Request $request, $id) {
        $request->validate([
            'catName' => 'required|string',
            'catType' => 'required|string',
        ]);

        $incomingData = ExpenseCategory::find($id);
        $incomingData->catName = $request->catName;
        $incomingData->catType = $request->catType;

        $incomingData->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Transaction Category updated successfully!');
        return redirect('/expense_ctg');
    }
    public function delete_trans_cat($id) {

        $data = ExpenseCategory::find($id);
        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Transaction Category deleted successfully!');
        return redirect()->back();
    }

    // Transaction related functions
    public function transactions() {
        $customer_transactions = CustomerTransaction::join('customers', 'customer_transactions.customerID', '=', 'customers.id')
            ->join('accounts', 'customer_transactions.account', '=', 'accounts.id')
            ->select(
                'customer_transactions.*',
                'customers.name as customer_name',
                'accounts.acc_name as account_name',
                'accounts.acc_no as account_no'
            )
            ->get();
        $supplier_transactions = SupplierTransaction::join('suppliers', 'supplier_transactions.supplierID', '=', 'suppliers.id')
            ->join('accounts', 'supplier_transactions.account', '=', 'accounts.id')
            ->select(
                'supplier_transactions.*',
                'suppliers.supplier_name as supplier_name',
                'accounts.acc_name as account_name',
                'accounts.acc_no as account_no'
            )
            ->get();
        $office_transactions = OfficeTransaction::join('accounts', 'office_transactions.account', '=', 'accounts.id')
            ->select(
                'office_transactions.*',
                'accounts.acc_name as account_name',
                'accounts.acc_no as account_no'
            )
            ->get();
        $employee_transactions = EmployeeTransaction::join('accounts', 'employee_transactions.account', '=', 'accounts.id')
            ->select(
                'employee_transactions.*',
                'accounts.acc_name as account_name',
                'accounts.acc_no as account_no'
            )
            ->get();

        return view('admin.transactions', compact('customer_transactions', 'supplier_transactions', 'office_transactions', 'employee_transactions'));
    }

    public function customer_trans() {
        $accounts = Account::all();
        $categories = ExpenseCategory::all();
        $sale_details = SaleDetail::all();

        // Fetch the max transactionNO from all tables
        $maxCustomerTransaction = DB::table('customer_transactions')->max('transactionNO');
        $maxSupplierTransaction = DB::table('supplier_transactions')->max('transactionNO');
        $maxOfficeTransaction = DB::table('office_transactions')->max('transactionNO');
        $maxEmployeeTransaction = DB::table('employee_transactions')->max('transactionNO');

        // Find the maximum of all values and increment by 1
        $nextTransactionNumber = max($maxCustomerTransaction, $maxSupplierTransaction, $maxOfficeTransaction, $maxEmployeeTransaction) + 1;

        return view('admin.add_transaction', compact('accounts', 'categories', 'sale_details', 'nextTransactionNumber'));
    }
    public function add_customer_trans(Request $request)
    {
        try {
            $transactionNO = $request->transactionNO;
            $customerID = $request->customerID;
            $amt_paid = $request->amt_paid;
            $pay_date = $request->pay_date;
            $account = $request->account;
            $description = $request->description;
            $doc_name = $request->doc_name;
            $doc_description = $request->doc_description;
            $image = $request->file('image');

            if ($image) {
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move('transactionDocs', $imagename);
            } else {
                $imagename = null;
            }

            // Insert stock details into the stock_details table
            DB::table('customer_transactions')->insert([
                'transactionNO' => $transactionNO,
                'customerID' => $customerID,
                'amt_paid' => $amt_paid,
                'pay_date' => $pay_date,
                'account' => $account,
                'description' => $description,
                'doc_name' => $doc_name,
                'doc_description' => $doc_description,
                'image' => $imagename,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Process each row of stock data and store it in the stocks table
            $rows = json_decode($request->rows, true); // Decode the rows from JSON to array

            foreach ($rows as $row) {
                // Update table
                DB::table('sale_details')
                    ->where('invoiceNo', $row['invoiceNo'])
                    ->decrement('cashDue', $row['paid']);

                DB::table('sale_details')
                    ->where('invoiceNo', $row['invoiceNo'])
                    ->update(['dueSettled' => $row['isSettled']]);

                DB::table('accounts')
                    ->where('id', $account)
                    ->increment('crnt_balance', $row['paid']);

                if ($row['isSettled'] == 'no') {
                    DB::table('customers')
                        ->where('id', $customerID)
                        ->decrement('due', $row['paid']);
                } elseif ($row['isSettled'] == 'yes') {
                    DB::table('customers')
                        ->where('id', $customerID)
                        ->decrement('due', $row['paid']);
                }
            }

            // Show success toastr message
            toastr()->timeOut(5000)->closeButton()->addSuccess('Customer Transaction added successfully!');
            return redirect()->back();

        } catch (\Exception $e) {
            // Show error toastr message
            toastr()->timeOut(5000)->closeButton()->addError('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function supplier_trans() {
        $accounts = Account::all();
        $categories = ExpenseCategory::all();
        $sale_details = SaleDetail::all();

        // Fetch the max transactionNO from all tables
        $maxCustomerTransaction = DB::table('customer_transactions')->max('transactionNO');
        $maxSupplierTransaction = DB::table('supplier_transactions')->max('transactionNO');
        $maxOfficeTransaction = DB::table('office_transactions')->max('transactionNO');
        $maxEmployeeTransaction = DB::table('employee_transactions')->max('transactionNO');

        // Find the maximum of all values and increment by 1
        $nextTransactionNumber = max($maxCustomerTransaction, $maxSupplierTransaction, $maxOfficeTransaction, $maxEmployeeTransaction) + 1;
        return view('admin.add_transaction', compact('accounts', 'categories', 'sale_details', 'nextTransactionNumber'));
    }
    public function supplier_search(Request $request)
    {
        $query = $request->input('query');
        $suppliers = Supplier::where('supplier_name', 'LIKE', "%{$query}%")
        ->orWhere('phone', 'LIKE', "%{$query}%")
        ->get();

        return response()->json($suppliers);
    }
    public function add_supplier_trans(Request $request) {
        $data = new SupplierTransaction;
        $data->transactionNO = $request->transactionNO;
        $data->supplierID = $request->supplierID;
        $data->amt_paid = $request->amt_paid;
        $data->pay_date = $request->pay_date;
        $data->account = $request->account;
        $data->description = $request->description;
        $data->doc_name = $request->doc_name;
        $data->doc_description = $request->doc_description;

        $image = $request->image;
        if ($image) {
            $imagename = time(). '.' .$image->getClientOriginalExtension();
            $request->image->move('transactionDocs', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        DB::table('accounts')
            ->where('id', $request->account)
            ->decrement('crnt_balance', $request->amt_paid);

        toastr()->timeOut(5000)->closeButton()->addSuccess('Supplier transaction added successfully!');
        return redirect('/transactions');
    }

    public function office_trans() {
        $accounts = Account::all();
        $categories = ExpenseCategory::all();
        $sale_details = SaleDetail::all();

        // Fetch the max transactionNO from all tables
        $maxCustomerTransaction = DB::table('customer_transactions')->max('transactionNO');
        $maxSupplierTransaction = DB::table('supplier_transactions')->max('transactionNO');
        $maxOfficeTransaction = DB::table('office_transactions')->max('transactionNO');
        $maxEmployeeTransaction = DB::table('employee_transactions')->max('transactionNO');

        // Find the maximum of all values and increment by 1
        $nextTransactionNumber = max($maxCustomerTransaction, $maxSupplierTransaction, $maxOfficeTransaction, $maxEmployeeTransaction) + 1;
        return view('admin.add_transaction', compact('accounts', 'categories', 'sale_details', 'nextTransactionNumber'));
    }
    public function add_office_trans(Request $request) {
        $data = new OfficeTransaction;
        $data->transactionNO = $request->transactionNO;
        $data->type = $request->type;
        $data->exp_type = $request->exp_type;
        $data->amt_paid = $request->amt_paid;
        $data->pay_date = $request->pay_date;
        $data->account = $request->account;
        $data->description = $request->description;
        $data->doc_name = $request->doc_name;
        $data->doc_description = $request->doc_description;

        $image = $request->image;
        if ($image) {
            $imagename = time(). '.' .$image->getClientOriginalExtension();
            $request->image->move('transactionDocs', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        if ($request->type == 'Expense') {
            DB::table('accounts')
                ->where('id', $request->account)
                ->decrement('crnt_balance', $request->amt_paid);
        } elseif ($request->type == 'Income') {
            DB::table('accounts')
                ->where('id', $request->account)
                ->increment('crnt_balance', $request->amt_paid);
        }

        toastr()->timeOut(5000)->closeButton()->addSuccess('Office transaction added successfully!');
        return redirect('/transactions');
    }

    public function employee_trans() {
        $accounts = Account::all();
        $categories = ExpenseCategory::all();
        $sale_details = SaleDetail::all();

        // Fetch the max transactionNO from all tables
        $maxCustomerTransaction = DB::table('customer_transactions')->max('transactionNO');
        $maxSupplierTransaction = DB::table('supplier_transactions')->max('transactionNO');
        $maxOfficeTransaction = DB::table('office_transactions')->max('transactionNO');
        $maxEmployeeTransaction = DB::table('employee_transactions')->max('transactionNO');

        // Find the maximum of all values and increment by 1
        $nextTransactionNumber = max($maxCustomerTransaction, $maxSupplierTransaction, $maxOfficeTransaction, $maxEmployeeTransaction) + 1;
        return view('admin.add_transaction', compact('accounts', 'categories', 'sale_details', 'nextTransactionNumber'));
    }
    public function add_employee_trans(Request $request) {
        $data = new EmployeeTransaction;
        $data->transactionNO = $request->transactionNO;
        $data->employee = $request->employee;
        $data->trans_type = $request->trans_type;
        $data->emp_trans_type = $request->emp_trans_type;
        $data->amt_paid = $request->amt_paid;
        $data->pay_date = $request->pay_date;
        $data->account = $request->account;
        $data->description = $request->description;
        $data->doc_name = $request->doc_name;
        $data->doc_description = $request->doc_description;

        $image = $request->image;
        if ($image) {
            $imagename = time(). '.' .$image->getClientOriginalExtension();
            $request->image->move('transactionDocs', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        if ($request->trans_type == 'Payment') {
            DB::table('accounts')
                ->where('id', $request->account)
                ->decrement('crnt_balance', $request->amt_paid);
        } elseif ($request->trans_type == 'Return') {
            DB::table('accounts')
                ->where('id', $request->account)
                ->increment('crnt_balance', $request->amt_paid);
        }

        toastr()->timeOut(5000)->closeButton()->addSuccess('Employee transaction added successfully!');
        return redirect('/transactions');
    }

    // Fund Transfer related functions
    public function fund_transfer() {
        $accounts = Account::all();
        $fund_transfers = FundTransfer::select(
            'fund_transfers.*',
            'account_from.acc_name as account_from_name',
            'account_from.acc_no as account_from_no',
            'account_to.acc_name as account_to_name',
            'account_to.acc_no as account_to_no'
        )
        ->join('accounts as account_from', 'fund_transfers.accountFrom', '=', 'account_from.id')
        ->join('accounts as account_to', 'fund_transfers.accountTo', '=', 'account_to.id')
        ->get();

        return view('admin.fund_transfer', compact('accounts', 'fund_transfers'));
    }
    public function getBalance(Request $request)
    {
        $accountId = $request->accountId;

        // Fetch the account balance
        $account = DB::table('accounts')->where('id', $accountId)->first();

        if ($account) {
            return response()->json(['crnt_balance' => $account->crnt_balance]);
        }

        return response()->json(['error' => 'Account not found'], 404);
    }
    public function add_fund_trans(Request $request) {
        $data = new FundTransfer();
        $data->accountFrom = $request->accountFrom;
        $data->accountTo = $request->accountTo;
        $data->amount = $request->amount;
        $data->description = $request->description;
        $data->user = Auth::user()->name;

        $data->save();

        DB::table('accounts')
            ->where('id', $request->accountFrom)
            ->decrement('crnt_balance', $request->amount);

        DB::table('accounts')
            ->where('id', $request->accountTo)
            ->increment('crnt_balance', $request->amount);

        toastr()->timeOut(5000)->closeButton()->addSuccess('Fund Transfered successfully!');
        return redirect()->back();
    }
}
