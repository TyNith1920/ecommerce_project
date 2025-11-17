<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * 🛍 Show product details page
     */
    public function product_details($id)
    {
        $data = Product::with('images')->findOrFail($id);

        // Related products (same category)
        $relatedProducts = Product::where('category', $data->category)
            ->where('id', '!=', $data->id)
            ->take(6)
            ->get();

        return view('home.product_details', compact('data', 'relatedProducts'));
    }

    /**
     * ➕ Add product to cart
     */
    public function add_to_cart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = new Cart();
        $cart->product_id = $product->id;
        $cart->title = $product->title;
        $cart->price = $product->discount_price ?? $product->price;
        $cart->quantity = $request->quantity ?? 1;
        $cart->size = $request->size ?? 'M';
        $cart->user_id = Auth::id();
        $cart->save();

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * ⚡ Buy Now (direct checkout)
     */
    public function buyNow($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Save temporary buy-now item in session
        Session::put('buy_now', [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->discount_price ?? $product->price,
            'quantity' => 1,
            'image' => $product->image,
        ]);

        return view('home.checkout', compact('product'));
    }

    /**
     * ✅ Confirm Order after Buy Now
     */
    public function confirmOrder(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Here you could insert into 'orders' table (if you have one)
        // Example only:
        // Order::create([...]);

        Session::forget('buy_now');

        return redirect('/')->with('success', 'Order placed successfully!');
    }
}
