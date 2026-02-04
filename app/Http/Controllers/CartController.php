<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Auth::user()->carts()->with('product')->get();
        $total = 0;
        
        foreach ($carts as $cart) {
            $total += $cart->product->price * (1 - $cart->product->sale/100) * $cart->quantity;
        }

        return view('cart.index', compact('carts', 'total'));
    }

    public function store(Request $request, Product $product)
    {
        // Validate request
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add items to cart'
                ], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();
        $quantity = $request->quantity;

        try {
            // Check if product already in cart
            $existingCart = $user->carts()->where('product_id', $product->id)->first();

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $quantity;
                if ($newQuantity > $product->quantity) {
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Quantity exceeds available stock'
                        ], 422);
                    }
                    return redirect()->back()->with('error', 'Quantity exceeds available stock');
                }
                $existingCart->update(['quantity' => $newQuantity]);
            } else {
                $user->carts()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity
                ]);
            }

            // Get updated cart count
            $cartCount = $user->carts()->count();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart successfully',
                    'cart_count' => $cartCount,
                    'item_total' => number_format($product->price * (1 - $product->sale/100) * $quantity, 2)
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Product added to cart');
            
        } catch (\Exception $e) {
            \Log::error('Cart store error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Server error: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error adding product to cart');
        }
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:' . $cart->product->quantity
        ]);

        try {
            $quantity = $request->quantity;
            
            // If quantity is 0 or less, delete the cart item
            if ($quantity <= 0) {
                $cart->delete();
                $message = 'Item removed from cart';
                $shouldRemove = true;
            } else {
                $cart->update(['quantity' => $quantity]);
                $message = 'Cart updated successfully';
                $shouldRemove = false;
            }

            // Recalculate cart total
            $user = auth()->user();
            $cartTotal = $user->carts()->with('product')->get()->sum(function($cart) {
                return $cart->product->price * (1 - $cart->product->sale/100) * $cart->quantity;
            });

            $cartCount = $user->carts()->count();

            // If it's an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                $response = [
                    'success' => true,
                    'message' => $message,
                    'cart_total' => number_format($cartTotal, 2),
                    'cart_count' => $cartCount,
                    'should_remove' => $shouldRemove
                ];
                
                // Only include item_total if item wasn't removed
                if (!$shouldRemove) {
                    $response['item_total'] = number_format($cart->product->price * (1 - $cart->product->sale/100) * $quantity, 2);
                }
                
                return response()->json($response);
            }

            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating cart'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error updating cart');
        }
    }

    public function getCartCount()
    {
        try {
            $count = auth()->check() ? auth()->user()->carts()->count() : 0;
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart count error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'count' => 0,
                'message' => 'Error fetching cart count'
            ], 500);
        }
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        return back()->with('success', 'Item removed from cart');
    }

    public function destroy(Request $request, $id)
    {
        try {
            $cart = Cart::findOrFail($id);
            
            // Verify the cart belongs to the authenticated user
            if ($cart->user_id !== auth()->id()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized action'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Unauthorized action');
            }
            
            $cart->delete();
    
            // Recalculate cart total
            $user = auth()->user();
            $cartTotal = $user->carts()->with('product')->get()->sum(function($cart) {
                return $cart->product->price * (1 - $cart->product->sale/100) * $cart->quantity;
            });
    
            $cartCount = $user->carts()->count();
    
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart',
                    'cart_total' => number_format($cartTotal, 2),
                    'cart_count' => $cartCount,
                    'should_remove' => true
                ]);
            }
    
            return redirect()->back()->with('success', 'Product removed from cart');
            
        } catch (\Exception $e) {
            \Log::error('Cart destroy error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error removing item from cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error removing item from cart');
        }
    }

    public function getCartSummary()
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        try {
            $user = auth()->user();
            $carts = $user->carts()->with('product')->get();
            
            $subtotal = 0;
            foreach ($carts as $cart) {
                $subtotal += $cart->product->price * (1 - $cart->product->sale/100) * $cart->quantity;
            }

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2), // Assuming shipping is free
                'count' => $carts->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart summary error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cart summary'
            ], 500);
        }
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->with('product')->get();
    
        if ($carts->isEmpty()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.'
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
    
        try {
            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $carts->sum(function($cart) {
                    return $cart->product->price * (1 - $cart->product->sale/100) * $cart->quantity;
                }),
                'status' => 'completed',
            ]);
    
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'sale' => $cart->product->sale,
                ]);
            }
    
            Cart::where('user_id', $user->id)->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your order was successfully placed!',
                    'redirect_url' => route('orders.index')
                ]);
            }
    
            return redirect()->route('orders.index')->with('success', 'Your order was successfully placed!');
            
        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error processing checkout'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error processing checkout');
        }
    }
}