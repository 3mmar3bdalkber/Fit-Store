<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user orders with pagination
        $orders = $user->orders()
            ->with(['orderItems' => function($query) {
                $query->with('product');
            }])
            ->latest()
            ->paginate(10);
        
        // Calculate total items
        $totalItems = 0;
        foreach ($orders as $order) {
            $totalItems += $order->orderItems->sum('quantity');
        }
        
        // Get wishlist count
        $wishlistCount = $user->wishlists()->count();
        
        return view('profile.index', compact('orders', 'totalItems', 'wishlistCount'));
    }
}