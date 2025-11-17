<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Product;

class SellerController extends Controller
{
    // បង្ហាញអ្នកលក់ទាំងអស់
    public function index()
    {
        $sellers = Seller::all();
        return view('home.seller_list', compact('sellers'));
    }

    // បង្ហាញព័ត៌មានអ្នកលក់តាម ID
    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        $products = Product::where('seller_id', $id)->get();

        return view('home.seller', compact('seller', 'products'));
    }
}
