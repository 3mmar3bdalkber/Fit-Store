<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['orderItems' => function($query) {
                $query->with('product');
            }])
            ->latest()
            ->paginate(10); // Changed from get() to paginate(10)
    
        return view('orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $order->load(['orderItems' => function($query) {
            $query->with('product');
        }]);
    
        return view('orders.show', compact('order'));
    }
}