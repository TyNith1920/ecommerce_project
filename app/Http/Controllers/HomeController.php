<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Services\PayWayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Models\Wishlist;
use Stripe;
// use Session;

class HomeController extends Controller
{
    protected $paywayService;

    public function __construct(PayWayService $paywayService)
    {
        $this->paywayService = $paywayService;
    }

    /**
     * Navbar badge: count total quantity (not just rows)
     */
    private function getCartCount()
    {
        if (!Auth::check()) return 0;

        // Some rows may have null quantity if created earlier → treat as 1
        return Cart::where('user_id', Auth::id())
            ->select(DB::raw('COALESCE(SUM(COALESCE(quantity,1)),0) as total_qty'))
            ->value('total_qty');
    }

    public function index()
    {
        $totalClients   = User::count();
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalDelivered = Order::where('status', 'Delivery')->count();

        return view('admin.dashboard', compact('totalClients', 'totalProducts', 'totalOrders', 'totalDelivered'));
    }


    public function home()
    {
        // 🛍 បង្ហាញផលិតផលថ្មីៗជាមួយ pagination
        $products = Product::latest()
            ->select(['id', 'title', 'price', 'discount_price', 'image', 'gallery', 'category', 'slug', 'created_at'])
            ->paginate(12)
            ->withQueryString();

        // ⚙️ ការទ្រទ្រង់សម្រាប់ compatibility ជាមួយ view ចាស់
        $product = $products->getCollection();

        // 🛒 ចំនួនសរុបនៅក្នុង Cart (method បងមានរួចហើយ)
        $count = $this->getCartCount();

        // 📂 ប្រភេទទាំងអស់ (សម្រាប់ dropdown)
        $categories = Product::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // 🧮 ប្រភេទនិងចំនួនផលិតផលក្នុងនោះ (សម្រាប់ sidebar)
        $categoriesCount = Product::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category', DB::raw('COUNT(*) as cnt'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        // ✅ ផ្ញើទិន្នន័យទាំងអស់ទៅទំព័រ Home / Shop
        return view('home.index', [
            'products'        => $products,         // Paginator
            'product'         => $product,          // Collection (compat)
            'categories'      => $categories,       // Simple list
            'categoriesCount' => $categoriesCount,  // With product counts
            'count'           => $count,            // Cart count
        ]);
    }


    public function login_home()
    {
        return $this->home();
    }

    public function product_details($id)
    {
        $data = Product::with('images')->findOrFail($id);
        $count = $this->getCartCount();

        return view('home.product_details', compact('data', 'count'));
    }

    /**
     * Add to cart: create with quantity=1 or increment if exists
     */
    public function add_to_cart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        $product = Product::findOrFail($id);

        // ✅ Check if product with same size & color already exists
        $existingCart = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('size', $request->size ?? null)
            ->where('color', $request->color ?? null)
            ->first();

        if ($existingCart) {
            // If it exists, just increase quantity
            $existingCart->quantity = ($existingCart->quantity ?? 1) + 1;
            $existingCart->save();

            toastr()->timeout(10000)->closeButton()->addInfo('✅ Quantity updated in your cart');
        } else {
            // Otherwise, add new cart item
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->product_id = $product->id;
            $cart->quantity = 1;
            $cart->size = $request->size ?? null;   // ✅ new
            $cart->color = $request->color ?? null; // ✅ new
            $cart->save();

            toastr()->timeout(10000)->closeButton()->addSuccess('🛒 Product added to your cart successfully');
        }

        return redirect()->back();
    }

    public function mycart()
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $userId = Auth::id();
        $count = $this->getCartCount();
        $cart  = Cart::with('product')->where('user_id', $userId)->get();

        // Calculate totals with quantity
        $amount  = 0;
        $savings = 0;
        foreach ($cart as $item) {
            $qty = $item->quantity ?? 1;
            if ($item->product->discount_price) {
                $amount  += $item->product->discount_price * $qty;
                $savings += ($item->product->price - $item->product->discount_price) * $qty;
            } else {
                $amount  += $item->product->price * $qty;
            }
        }
        $amount = number_format($amount, 2, '.', '');

        // === ABA PayWay Sandbox Configuration ===
        $req_time      = time();
        $tran_id       = time();
        $merchant_id   = 'ec462059'; // Sandbox Merchant ID
        $currency      = 'USD';
        $payment_option = '';

        // === Generate Secure Hash ===
        $secret_key = env('ABA_HASH_KEY', '123456');
        $string_to_sign = $merchant_id . $tran_id . $amount . $req_time;
        $hash = hash_hmac('sha512', $string_to_sign, $secret_key);

        return view('home.mycart', compact(
            'count',
            'cart',
            'merchant_id',
            'tran_id',
            'amount',
            'currency',
            'payment_option',
            'req_time',
            'hash',
            'savings'
        ));
    }

    public function delete_cart($id)
    {
        $cart = Cart::find($id);

        if ($cart && $cart->user_id === Auth::id()) {
            $cart->delete();
            toastr()->timeout(10000)->closeButton()->addSuccess('Product removed from your cart');
        } else {
            toastr()->timeout(10000)->closeButton()->addError('Item not found or unauthorized');
        }

        return redirect()->back();
    }

    public function confirm_order(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
        ]);

        $userId = Auth::id();
        $cart   = Cart::with('product')->where('user_id', $userId)->get();

        foreach ($cart as $c) {
            $order = new Order();
            $order->name        = $request->name;
            $order->rec_address = $request->address;
            $order->phone       = $request->phone;
            $order->user_id     = $userId;
            $order->product_id  = $c->product_id;
            // If your orders table has quantity column, uncomment next line
            // $order->quantity    = $c->quantity ?? 1;
            $order->save();
        }

        Cart::where('user_id', $userId)->delete();

        toastr()->timeout(10000)->closeButton()->addSuccess('Product Ordered Successfully');
        return redirect()->back();
    }

    /**
     * Admin-only helper: delete product + its cart rows
     */
    public function delete_product($id)
    {
        Cart::where('product_id', $id)->delete();

        $product = Product::find($id);

        if ($product) {
            $product->delete();
            toastr()->timeout(10000)->closeButton()->addSuccess('Product deleted successfully');
        } else {
            toastr()->timeout(10000)->closeButton()->addError('Product not found');
        }

        return redirect()->back();
    }

    public function product_details_by_slug($slug)
    {
        $data = Product::with('images')->where('slug', $slug)->firstOrFail();
        $count = $this->getCartCount();

        $relatedProducts = Product::where('category', $data->category)
            ->where('id', '!=', $data->id)
            ->latest()->take(6)->get();

        return view('home.product_details', compact('data', 'count', 'relatedProducts'));
    }

    public function myorders()
    {
        $userId = Auth::id();
        $count  = $this->getCartCount();
        $order  = Order::where('user_id', $userId)->get();

        return view('home.order', compact('count', 'order'));
    }

    public function stripe($value)
    {
        return view('home.stripe', compact('value'));
    }

    public function stripePost(Request $request, $value)
    {
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            Stripe\Charge::create([
                "amount"      => $value * 100,
                "currency"    => "usd",
                "source"      => $request->stripeToken,
                "description" => "Test payment from complete"
            ]);
        } catch (\Exception $e) {
            toastr()->timeout(10000)->closeButton()->addError($e->getMessage());
            return back();
        }

        $user = Auth::user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();

        foreach ($cart as $c) {
            $order = new Order();
            $order->name           = $user->name;
            $order->rec_address    = $user->address;
            $order->phone          = $user->phone;
            $order->user_id        = $user->id;
            $order->payment_status = "paid";
            $order->product_id     = $c->product_id;
            // If orders table has quantity:
            // $order->quantity       = $c->quantity ?? 1;
            $order->save();
        }

        Cart::where('user_id', $user->id)->delete();

        toastr()->timeout(10000)->closeButton()->addSuccess('Product Ordered Successfully');

        return redirect('mycart');
    }

    public function shop()
    {
        $products = \App\Models\Product::query()
            ->when(request('q'), function ($q) {
                $term = request('q');
                $q->where(function ($qq) use ($term) {
                    $qq->where('title', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->when(request('category'), fn($q) => $q->where('category', request('category')))
            ->when(request()->boolean('only_discount'), fn($q) => $q->whereNotNull('discount_price'))
            ->when(is_numeric(request('min')), fn($q) => $q->where('price', '>=', (float) request('min')))
            ->when(is_numeric(request('max')), fn($q) => $q->where('price', '<=', (float) request('max')))
            ->when(request('sort', 'newest'), function ($q, $sort) {
                if ($sort === 'price_asc')      $q->orderBy('price', 'asc');
                elseif ($sort === 'price_desc') $q->orderBy('price', 'desc');
                else                             $q->latest('id');
            })
            ->select(['id', 'title', 'price', 'discount_price', 'image', 'gallery', 'category'])
            ->paginate(9)
            ->withQueryString();

        $count = $this->getCartCount();

        $categoriesCount = \App\Models\Product::query()
            ->whereNotNull('category')->where('category', '!=', '')
            ->select('category', \Illuminate\Support\Facades\DB::raw('COUNT(*) as cnt'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('home.product', [
            'products'        => $products,
            'categoriesCount' => $categoriesCount,
            'count'           => $count,
        ]);
    }

    public function why()
    {
        $count = $this->getCartCount();
        return view('home.why', compact('count'));
    }

    public function testimonial()
    {
        $count = $this->getCartCount();
        return view('home.testimonial', compact('count'));
    }

    public function contact()
    {
        $count = $this->getCartCount();
        return view('home.contact', compact('count'));
    }

    /**
     * AJAX: increase/decrease quantity + return fresh totals & header count
     */
    public function update_cart(Request $request, $id)
    {
        // Ensure $request is defined in this scope (useful if called in contexts where it's not injected)
        $request = request();

        // Support cases where $id may not be provided as a method parameter (e.g., AJAX payload or route mismatch)
        if (!isset($id) || empty($id)) {
            $id = $request->route('id') ?? $request->input('id') ?? null;
        }

        if (!$id) {
            return response()->json(['error' => 'Cart item id not provided.'], 400);
        }

        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        // Update quantity based on action
        if ($request->action === 'increase') {
            $cart->quantity = ($cart->quantity ?? 1) + 1;
        } elseif ($request->action === 'decrease') {
            $cart->quantity = max(1, ($cart->quantity ?? 1) - 1);
        } elseif ($request->action === 'custom_update') {
            $cart->color = $request->color;
            $cart->size = $request->size;
            $cart->quantity = max(1, intval($request->quantity));
        }


        $cart->save();

        // Recalculate total and savings for this user
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $total = 0;
        $savings = 0;

        foreach ($cartItems as $item) {
            $qty = $item->quantity ?? 1;
            if ($item->product->discount_price) {
                $total   += $item->product->discount_price * $qty;
                $savings += ($item->product->price - $item->product->discount_price) * $qty;
            } else {
                $total += $item->product->price * $qty;
            }
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Cart updated successfully!',
            'cart_id'  => $cart->id,
            'quantity' => $cart->quantity,
            'total'    => number_format($total, 2),
            'savings'  => number_format($savings, 2),
            'count'    => $this->getCartCount(), // for header badge update
        ]);
    }

    /**
     * AJAX: cart totals (for summary refresh)
     */
    public function cartSummary()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        $total = 0;
        $savings = 0;

        foreach ($cartItems as $item) {
            $qty = $item->quantity ?? 1;
            if ($item->product->discount_price) {
                $total   += $item->product->discount_price * $qty;
                $savings += ($item->product->price - $item->product->discount_price) * $qty;
            } else {
                $total += $item->product->price * $qty;
            }
        }

        return response()->json([
            'total'   => number_format($total, 2),
            'savings' => number_format($savings, 2)
        ]);
    }

    public function view_order($id = null)
    {
        // resolve id from argument, route or request input for robustness
        $id = $id ?? request()->route('id') ?? request()->input('id');

        if (!$id) {
            abort(404);
        }

        $order = \App\Models\Order::with('product')->findOrFail($id);
        $count = $this->getCartCount();

        return view('home.view_order', compact('order', 'count'));
    }

    /**
     * AJAX: navbar badge count (sum of quantities)
     */
    public function cartCount()
    {
        if (!Auth::check()) return response()->json(['count' => 0]);

        $count = $this->getCartCount();
        return response()->json(['count' => (int)$count]);
    }
    public function admin_cart_items()
    {
        $cartItems = \App\Models\Cart::with(['user', 'product'])->latest()->get();
        return view('admin.cart.index', compact('cartItems'));
    }

    public function admin_cart_edit($id = null)
    {
        // allow calling this method without an explicit $id by resolving from route or input
        $id = $id ?? request()->route('id') ?? request()->input('id');

        if (!$id) {
            // no id available — respond with 404
            abort(404);
        }

        $cart = \App\Models\Cart::with(['user', 'product'])->findOrFail($id);
        return view('admin.cart.update_page', compact('cart'));
    }

    public function admin_cart_update(Request $request, $id = null)
    {
        // Ensure we have a request object even if the $request variable is missing in some call contexts
        $req = isset($request) ? $request : request();

        // Resolve $id from parameter, route or request input for robustness
        $id = $id ?? $req->route('id') ?? $req->input('id');

        if (!$id) {
            abort(404);
        }

        $cart = \App\Models\Cart::findOrFail($id);
        $cart->color = $req->color;
        $cart->size = $req->size;
        $cart->quantity = max(1, (int)$req->quantity);
        $cart->save();

        toastr()->success('Cart item updated successfully!');
        return redirect()->route('admin.cart.index');
    }
}
