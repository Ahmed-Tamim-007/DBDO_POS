<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Inventory;
use Stripe;

class HomeController extends Controller
{
    // Home page functions
    public function home() {
        $products = Product::all();
        $categories = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.index', compact('products', 'count', 'categories'));
    }

    // Logging in
    public function login_home() {
        $products = Product::all();
        $categories = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.index', compact('products', 'count', 'categories'));
    }

    // Showing product details
    public function product_details($id) {
        $product = Product::with(['stocks' => function ($query) {
            $query->orderBy('batch_no')->where('quantity', '>', 0);
        }])->findOrFail($id);

        // Calculate total quantity for the product
        $product->total_quantity = $product->stocks->sum('quantity');

        // Get the oldest batch with quantity > 0 for selling price
        $oldestBatch = $product->stocks->where('quantity', '>', 0)->first();
        $product->batch_no = $oldestBatch ? $oldestBatch->batch_no : null;
        $product->sale_price = $oldestBatch ? $oldestBatch->sale_price : null;

        $categories = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.product_details', compact('product', 'count', 'categories'));
    }

    // Showing Category details
    public function category_details(Request $request, $id) {
        $categories = Category::find($id);
        $category_all = Category::all();

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $products = Product::with(['stocks' => function ($query) {
            $query->orderBy('batch_no')->where('quantity', '>', 0);
        }])
        ->when($minPrice, function ($query) use ($minPrice) {
            return $query->whereHas('stocks', function ($query) use ($minPrice) {
                $query->where('sale_price', '>=', $minPrice);
            });
        })
        ->when($maxPrice, function ($query) use ($maxPrice) {
            return $query->whereHas('stocks', function ($query) use ($maxPrice) {
                $query->where('sale_price', '<=', $maxPrice);
            });
        })
        ->paginate(50);

        foreach ($products as $product) {
            // Calculate total quantity for the product
            $product->total_quantity = $product->stocks->sum('quantity');

            // Get the oldest batch with quantity > 0 for selling price
            $oldestBatch = $product->stocks->where('quantity', '>', 0)->first();
            $product->sale_price = $oldestBatch ? $oldestBatch->sale_price : null;
        }

        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.category_details', compact('products', 'count', 'categories', 'category_all'));
    }

    // Product Search
    public function search(Request $request)
    {
        $searchQuery = $request->input('q');

        $products = Product::where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('category', 'LIKE', "%{$searchQuery}%")
                    ->with(['inventories' => function ($query) {
                        $query->orderBy('batch_no')->where('quantity', '>', 0);
                    }])
                    ->paginate(10)
                    ->appends(['q' => $searchQuery]);

        // Calculate total quantity and selling price for each product
        foreach ($products as $product) {
            $product->total_quantity = $product->inventories->sum('quantity');

            // Get the oldest batch with quantity > 0 for selling price
            $oldestBatch = $product->inventories->where('quantity', '>', 0)->first();
            $product->selling_price = $oldestBatch ? $oldestBatch->selling_price : null;
        }

        $category_all = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        // Check if there are no results and set a message if needed
        $message = $products->isEmpty() ? "No results found for '{$searchQuery}'." : null;

        return view('home.search-results', compact('products', 'searchQuery', 'category_all', 'count', 'message'));
    }

    // Adding to the carts
    public function add_cart($id) {
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;

        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;

        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product added to cart successfully!');
        return redirect()->back();
    }

    // Showing user carts
    public function mycart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();

            // Fetch the cart items with product and inventory relations
            $cart = Cart::where('user_id', $userid)->with(['product', 'inventory'])->get();

            foreach ($cart as $item) {
                // Calculate the total available quantity from all inventory batches
                $item->total_quantity = $item->inventory->sum('quantity');

                // Get the selling price from the oldest available inventory batch with quantity > 0
                $oldestBatch = $item->inventory->first();
                $item->selling_price = $oldestBatch ? $oldestBatch->selling_price : 0;
            }
        }

        return view('home.mycart', compact('count', 'cart'));
    }

    // CartItem quantity increment
    public function incrementQuantity($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        }

        return redirect()->back();
    }
    // CartItem quantity decrement
    public function decrementQuantity($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
        }

        return redirect()->back();
    }

    // Removing cart function
    public function remove_cart($id) {
        $data = Cart::find($id);
        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Cart deleted successfully!');
        return redirect()->back();
    }

    // Confirming order function
    public function confirm_order(Request $request) {
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();

        foreach ($cartItems as $cartItem) {
            $remainingQuantity = $cartItem->quantity;
            $inventoryBatches = Inventory::where('product_id', $cartItem->product_id)
                ->where('quantity', '>', 0)
                ->orderBy('batch_no', 'asc')
                ->get();

            foreach ($inventoryBatches as $inventory) {
                if ($remainingQuantity <= 0) break;

                $orderQuantity = min($remainingQuantity, $inventory->quantity);

                $order = new Order([
                    'user_id' => $userId,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $orderQuantity,
                    'selling_price' => $inventory->selling_price*$orderQuantity,
                    'batch_no' => $inventory->batch_no,
                    'name' => $name,
                    'rec_address' => $address,
                    'phone' => $phone
                ]);

                $order->save();

                // Update inventory quantity
                $inventory->decrement('quantity', $orderQuantity);

                // Adjust remaining quantity for multi-batch fulfillment
                $remainingQuantity -= $orderQuantity;
            }
        }

        // Clear the cart for the user after the order is confirmed
        Cart::where('user_id', $userId)->delete();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Order placed successfully!');
        return redirect()->back();
    }

    // User orders function
    public function myorders() {
        $user = Auth::user()->id;
        $count = Cart::where('user_id', $user)->get()->count();
        $order = Order::where('user_id', $user)->get();
        return view('home.order', compact('count', 'order'));
    }

    // User orders function
    public function myreview() {
        $user = Auth::user()->id;
        $count = Cart::where('user_id', $user)->get()->count();
        $order = Order::where('user_id', $user)->get();
        return view('home.review', compact('count', 'order'));
    }

    // Stripe page function
    public function stripe($value) {
        return view('home.stripe', compact('value'));
    }

    // Shop post function
    public function stripePost(Request $request, $value){
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([

                "amount" => $value * 100,

                "currency" => "usd",

                "source" => $request->stripeToken,

                "description" => "Test payment complete"

        ]);

        $name = Auth::user()->name;
        $address = Auth::user()->address;
        $phone = Auth::user()->phone;
        $userid = Auth::user()->id;
        $cart = Cart::where('user_id', $userid)->get();

        foreach($cart as $carts) {
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $carts->product_id;
            $order->payment_status = 'paid';
            $order->save();
        }
        $cart_remove = Cart::where('user_id', $userid)->get();
        foreach ($cart_remove as $remove) {
            $data = Cart::find("$remove->id");
            $data->delete();
        }

        toastr()->timeOut(5000)->closeButton()->addSuccess('Payment was successfull!');
        return redirect('mycart');
    }

    // Shop page function
    public function shop(Request $request) {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $products = Product::with(['stocks' => function ($query) {
            $query->orderBy('batch_no')->where('quantity', '>', 0);
        }])
        ->when($minPrice, function ($query) use ($minPrice) {
            return $query->whereHas('stocks', function ($query) use ($minPrice) {
                $query->where('sale_price', '>=', $minPrice);
            });
        })
        ->when($maxPrice, function ($query) use ($maxPrice) {
            return $query->whereHas('stocks', function ($query) use ($maxPrice) {
                $query->where('sale_price', '<=', $maxPrice);
            });
        })
        ->paginate(50);

        foreach ($products as $product) {
            // Calculate total quantity for the product
            $product->total_quantity = $product->stocks->sum('quantity');

            // Get the oldest batch with quantity > 0 for selling price
            $oldestBatch = $product->stocks->where('quantity', '>', 0)->first();
            $product->sale_price = $oldestBatch ? $oldestBatch->sale_price : null;
        }

        $categories = Category::all();
        $brands = Brand::all();

        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.shop', compact('products', 'count', 'categories', 'brands'));
    }

    // AboutUs page function
    public function about() {
        $product = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.aboutus', compact('product', 'count'));
    }

    // ContactUs page function
    public function contact() {
        $product = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.contactus', compact('product', 'count'));
    }
}
