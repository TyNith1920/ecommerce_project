<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // ===============================
    // 📊 Dashboard
    // ===============================
    public function dashboard()
    {
        $totalClients   = User::count();
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalDelivered = Order::where('status', 'Delivery')->count();

        return view('admin.dashboard', compact('totalClients', 'totalProducts', 'totalOrders', 'totalDelivered'));
    }

    // ===============================
    // 📂 CATEGORY MANAGEMENT
    // ===============================
    public function view_category()
    {
        $data = Category::latest()->get();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:categories,category_name',
        ]);

        Category::create([
            'category_name' => $request->category
        ]);

        toastr()->timeout(8000)->closeButton()->addSuccess('✅ Category Added Successfully!');
        return back();
    }

    public function edit_category($id)
    {
        $data = Category::findOrFail($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:categories,category_name,' . $id,
        ]);

        // យក category តាម id
        $category = Category::findOrFail($id);

        // 👉 ឈ្មោះចាស់ (ដែលកំពុងមានក្នុង products.category)
        $oldName = $category->category_name;

        // 👉 ប្តូរឈ្មោះថ្មីក្នុង categories table
        $category->update([
            'category_name' => $request->category
        ]);

        // ⭐ UPDATE ក្នុង products table ផង
        Product::where('category', $oldName)
            ->update(['category' => $category->category_name]);

        toastr()->timeout(8000)->closeButton()->addSuccess('✅ Category Updated Successfully!');
        return redirect()->route('admin.categories.index');
    }


    public function delete_category($id)
    {
        $category = Category::findOrFail($id);

        // ⭐ លុប reference ក្នុង products (ដាក់ category = null)
        Product::where('category', $category->category_name)
            ->update(['category' => null]);

        // បន្ទាប់មកទើបលុប category
        $category->delete();

        toastr()->timeout(8000)->closeButton()->addSuccess('🗑️ Category Deleted Successfully!');
        return back();
    }


    // ===============================
    // 📦 PRODUCT MANAGEMENT
    // ===============================
    public function add_product()
    {
        $category = Category::all();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'qty'            => 'required|integer|min:1',
            'category'       => 'required|string',
            'image'          => 'required|image|mimes:jpeg,png,jpg|max:10240', // 100MB max
            'images.*'       => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // ✅ gallery
        ]);

        // 🧱 Save main product
        $product = new Product;
        $product->title          = $request->title;
        $product->description    = $request->description;
        $product->price          = $request->price;
        $product->discount_price = $request->discount_price;
        $product->quantity       = $request->qty;
        $product->category       = $request->category;

        if ($request->hasFile('image')) {
            $imagename = time() . '_main.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('products'), $imagename);
            $product->image = $imagename;
        }

        $product->save();

        // 🖼 Save multiple gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('products'), $name);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $name,
                    ]);
                }
            }
        }

        toastr()->timeout(8000)->closeButton()->addSuccess('✅ Product Added with Gallery!');
        return redirect()->route('admin.products.index');
    }

    public function delete_product($id)
    {
        $product = Product::with('images')->findOrFail($id);

        // Delete gallery images
        foreach ($product->images as $img) {
            $path = public_path('products/' . $img->image);
            if (file_exists($path)) unlink($path);
            $img->delete();
        }

        // Delete main image
        if ($product->image && file_exists(public_path('products/' . $product->image))) {
            unlink(public_path('products/' . $product->image));
        }

        $product->delete();

        toastr()->timeout(8000)->closeButton()->addSuccess('🗑️ Product + Gallery Deleted!');
        return back();
    }

    public function product_search(Request $request)
    {
        $search = $request->search;
        $product = Product::query()
            ->where('title', 'LIKE', "%$search%")
            ->orWhere('category', 'LIKE', "%$search%")
            ->paginate(5);

        return view('admin.view_product', compact('product'));
    }
    public function view_product()
    {
        $product = Product::latest()->paginate(5);
        return view('admin.view_product', compact('product'));
    }
    public function show_edit_product($id)
    {
        // 🔍 រកផលិតផលតាម ID និងរួមបញ្ចូលរូបភាព
        $data = Product::with('images')->findOrFail($id);

        // ✅ ទាញ category ទាំងអស់
        $categories = Category::all();

        // ✅ ទាញរូប gallery images របស់ផលិតផល
        $galleryImages = $data->images;

        // ✅ ផ្ញើទាំងអស់ទៅ view
        return view('admin.edit_product', compact('data', 'galleryImages', 'categories'));
    }



    public function edit_product(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // ✅ Validation
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'quantity' => 'required|integer|min:1',
                'category' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
                'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            ]);

            // ✅ Update info
            $product->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'quantity' => $validated['quantity'],
                'category' => $validated['category'],
            ]);

            // ✅ Update main image
            if ($request->hasFile('image')) {
                $imagename = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('products'), $imagename);

                if ($product->image && file_exists(public_path('products/' . $product->image))) {
                    unlink(public_path('products/' . $product->image));
                }

                $product->image = $imagename;
                $product->save();
            }

            // ✅ Upload gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $fileName = uniqid() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('products/gallery'), $fileName);
                    $product->images()->create(['image' => $fileName]);
                }
            }

            // ✅ Warning if no changes
            if (!$product->wasChanged() && !$request->hasFile('image') && !$request->hasFile('gallery')) {
                toastr()->timeout(6000)->closeButton()->addWarning('⚠️ No changes detected.');
                return redirect()->back();
            }

            toastr()->timeout(8000)->closeButton()->addSuccess('✅ Product Updated Successfully!');
            return redirect()->route('admin.products.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->validator->errors()->all() as $error) {
                toastr()->timeout(10000)->closeButton()->addError('⚠️ ' . $error);
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            toastr()->timeout(8000)->closeButton()->addError('❌ Update failed: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function update_product(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;

        // ✅ Upload image if selected
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();

            // Move image to public/products
            $image->move(public_path('products'), $imagename);

            // Delete old image if exists
            if ($product->image && file_exists(public_path('products/' . $product->image))) {
                unlink(public_path('products/' . $product->image));
            }

            $product->image = $imagename;
        }

        $product->save();

        toastr()->timeout(8000)->closeButton()->addSuccess('✅ Product updated successfully!');
        return redirect()->route('admin.products.index');
    }



    // ===============================
    // 🛍 ORDER MANAGEMENT
    // ===============================
    public function view_order(Request $request)
    {
        $query = Order::with('product')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('product', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $data = $query->get();
        return view('admin.order', compact('data'));
    }

    public function delivered($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'Delivery']);

        toastr()->timeout(8000)->closeButton()->addSuccess('📦 Order Delivered Successfully!');
        return redirect()->route('admin.orders.index');
    }
    public function on_the_way($id)
    {
        $order = Order::findOrFail($id);

        // ប្តូរស្ថានភាព Order
        $order->update(['status' => 'On the way']);

        toastr()->timeout(8000)->closeButton()->addSuccess('🚚 Order marked as On The Way!');
        return redirect()->route('admin.orders.index');
    }


    public function print_pdf($id)
    {
        $data = Order::with('product')->find($id);

        if (!$data) {
            abort(404, 'Order not found');
        }

        // ប្រាកដថា path រូបមានពិត
        $imagePath = public_path('products/' . $data->product->image ?? '');
        if (!File::exists($imagePath)) {
            $imagePath = public_path('images/no-image.png'); // fallback
        }

        $pdf = Pdf::loadView('admin.invoice', compact('data'))
            ->setPaper('A4', 'portrait');

        $filename = 'Invoice_' . $data->id . '_' . now('Asia/Phnom_Penh')->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }


    // ===============================
    // 🛒 CART MANAGEMENT
    // ===============================
    public function cartItems()
    {
        $cart = Cart::with(['user', 'product'])->get();
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $deliveredCount = Order::where('status', 'Delivery')->count();

        return view('admin.cart.index', compact('cart', 'userCount', 'productCount', 'orderCount', 'deliveredCount'));
    }

    public function editCart($id)
    {
        $cart = Cart::with(['user', 'product'])->findOrFail($id);
        return view('admin.cart.update_page', compact('cart'));
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'color'    => 'nullable|string|max:50',
            'size'     => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::findOrFail($id);
        $cart->update($request->only('color', 'size', 'quantity'));

        toastr()->timeout(8000)->closeButton()->addSuccess('✅ Cart Item Updated Successfully!');
        return redirect()->route('admin.cart.index');
    }

    public function deleteCart($id)
    {
        Cart::findOrFail($id)->delete();
        toastr()->timeout(8000)->closeButton()->addSuccess('🗑️ Cart Item Deleted Successfully!');
        return redirect()->route('admin.cart.index');
    }
    public function deleteImage($id)
    {
        $image = \App\Models\ProductImage::findOrFail($id);
        $path = public_path('products/gallery/' . $image->image);

        if (file_exists($path)) {
            unlink($path);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }
}
