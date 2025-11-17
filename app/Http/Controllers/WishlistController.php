<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ត្រូវ login មុន
    }

    /** GET /wishlist */
    public function index()
    {
        $count = method_exists(app(HomeController::class), 'getCartCount')
            ? app(HomeController::class)->cartCount()->getData()->count ?? 0
            : 0;

        $items = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home.wishlist', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /** POST /wishlist/toggle */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
        ]);

        $userId = Auth::id();
        $productId = (int) $request->product_id;

        $existing = Wishlist::where('user_id',$userId)->where('product_id',$productId)->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['ok' => true, 'action' => 'removed']);
        }

        Wishlist::create(['user_id'=>$userId, 'product_id'=>$productId]);
        return response()->json(['ok' => true, 'action' => 'added']);
    }

    /** DELETE /wishlist/{product}  (optional remove by product) */
    public function destroy(Product $product)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return redirect()->back()->with('success', 'Removed from wishlist');
    }
}
