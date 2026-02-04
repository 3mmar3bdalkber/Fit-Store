<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function store(Request $request, Product $product)
    {
        $user = Auth::user();
        
        // Check if product already in wishlist
        if ($user->wishlists()->where('product_id', $product->id)->exists()) {
            return redirect()->back()->with('error', 'Product already in wishlist');
        }

        $user->wishlists()->create([
            'product_id' => $product->id
        ]);

        return redirect()->back()->with('success', 'Product added to wishlist');
    }

    public function destroy(Product $product)
    {
        Auth::user()->wishlists()->where('product_id', $product->id)->delete();
        return redirect()->back()->with('success', 'Product removed from wishlist');
    }
}