@extends('products/layout')

@section('content')
<div class="fitstore-cart-container">
    <h1 class="fitstore-cart-heading">Your Shopping Cart</h1>
    
    @if(session('success'))
        <div class="fitstore-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($carts->isEmpty())
        <div class="empty-cart text-center py-5">
            <i class="fas fa-shopping-cart fa-5x mb-4"></i>
            <h3>Your cart is empty</h3>
            <a href="{{ route('products.index') }}" class="fitstore-btn primary">Continue Shopping</a>
        </div>
    @else
        <div class="cart-items-container">
            @foreach($carts as $cart)
                <div class="cart-item" data-cart-id="{{ $cart->id }}">
                    <div class="item-product">
                        <img src="{{ asset('product_images/' . $cart->product->image1) }}" 
                             alt="{{ $cart->product->name }}"
                             class="product-thumbnail">
                        <div class="product-details">
                            <h4>{{ $cart->product->name }}</h4>
                            <p class="product-variant">{{ $cart->product->color }}</p>
                            <p class="product-stock">In stock: {{ $cart->product->quantity }}</p>
                        </div>
                    </div>
                    <div class="item-price">
                        @if($cart->product->sale > 0)
                            <span class="original-price">LE {{ number_format($cart->product->price, 2) }}</span>
                            <span class="sale-price">LE {{ number_format($cart->product->price * (1 - $cart->product->sale/100), 2) }}</span>
                        @else
                            <span>LE {{ number_format($cart->product->price, 2) }}</span>
                        @endif
                    </div>
                    <div class="item-quantity">
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn minus" data-action="decrease">-</button>
                            <input type="number" 
                                   value="{{ $cart->quantity }}" 
                                   min="0" 
                                   max="{{ $cart->product->quantity }}"
                                   class="quantity-input"
                                   data-cart-id="{{ $cart->id }}"
                                   data-unit-price="{{ $cart->product->price * (1 - $cart->product->sale/100) }}">
                            <button type="button" class="quantity-btn plus" data-action="increase">+</button>
                        </div>
                        <div class="update-status" id="update-status-{{ $cart->id }}"></div>
                    </div>
                    <div class="item-total" id="total-{{ $cart->id }}">
                        LE {{ number_format($cart->product->price * (1 - $cart->product->sale/100) * $cart->quantity, 2) }}
                    </div>
                    <div class="item-actions">
                        <button type="button" class="remove-btn" data-cart-id="{{ $cart->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span id="cart-subtotal">LE {{ number_format($total, 2) }}</span>
            </div>
            <div class="summary-row shipping">
                <span>Shipping:</span>
                <span>FREE</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span id="cart-total">LE {{ number_format($total, 2) }}</span>
            </div>
            <div class="cart-actions">
                <a href="{{ route('products.index') }}" class="fitstore-btn outline">
                    Continue Shopping
                </a>
                <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                    @csrf
                    <button type="submit" class="fitstore-btn primary" id="checkout-btn">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>

<style>

    .fitstore-cart-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Arial', sans-serif;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    /* Heading */
    .fitstore-cart-heading {
        font-size: 28px;
        color: #333;
        margin-bottom: 30px;
        text-align: center;
        font-weight: 700;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    /* Cart Items */
    .cart-items-container {
        margin-bottom: 30px;
    }

    /* Cart Item */
    .cart-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    /* Product Column */
    .item-product {
        flex: 2;
        display: flex;
        align-items: center;
    }
    .product-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 15px;
    }
    .product-details h4 {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: 600;
    }
    .product-variant {
        color: #666;
        font-size: 14px;
        margin: 0;
    }

    /* Price Column */
    .item-price {
        flex: 1;
        text-align: center;
    }
    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
    }
    .sale-price {
        color: #d82e2e;
        font-weight: bold;
    }

    /* Quantity Column */
    .item-quantity {
        flex: 1;
        text-align: center;
    }
    .quantity-selector {
        display: inline-flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .quantity-btn {
        width: 30px;
        height: 30px;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    .quantity-btn:hover {
        background-color: #e8e8e8;
    }
    .quantity-input {
        width: 50px;
        height: 30px;
        text-align: center;
        border: 1px solid #ddd;
        border-left: none;
        border-right: none;
        font-size: 14px;
    }
    
    /* Update Status */
    .update-status {
        font-size: 11px;
        height: 16px;
        margin-top: 3px;
        text-align: center;
        transition: all 0.3s;
    }
    
    .update-status.updating {
        color: #007bff;
    }
    
    .update-status.success {
        color: #28a745;
    }
    
    .update-status.error {
        color: #dc3545;
    }

    /* Total Column */
    .item-total {
        flex: 1;
        text-align: center;
        font-weight: bold;
    }

    /* Actions Column */
    .item-actions {
        flex: 0.5;
        text-align: center;
    }
    .remove-btn {
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 16px;
        transition: color 0.3s;
        padding: 5px;
    }
    .remove-btn:hover {
        color: #d82e2e;
    }

    /* Cart Summary */
    .cart-summary {
        background-color: #f8f8f8;
        padding: 25px;
        border-radius: 8px;
        margin-top: 30px;
    }
    .cart-summary h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 20px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    .summary-row.shipping {
        color: #2e8b57;
    }
    .summary-row.total {
        font-weight: bold;
        font-size: 18px;
        padding-top: 15px;
        border-top: 1px solid #ddd;
        margin-top: 10px;
    }

    /* Cart Actions */
    .cart-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    .cart-actions .fitstore-btn {
        flex: 1;
        text-align: center;
    }

    /* Buttons */
    .fitstore-btn {
        padding: 12px;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        border: none;
        font-size: 16px;
    }
    .fitstore-btn.primary {
        background-color: #d82e2e;
        color: white;
        border: none;
    }
    .fitstore-btn.primary:hover {
        background-color: #b82525;
    }
    .fitstore-btn.primary:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
    .fitstore-btn.outline {
        background-color: transparent;
        border: 1px solid #d82e2e;
        color: #d82e2e;
    }
    .fitstore-btn.outline:hover {
        background-color: #f8f8f8;
    }

    /* Empty State */
    .empty-cart {
        padding: 40px 20px;
        text-align: center;
    }
    .empty-cart i {
        color: #d82e2e;
        margin-bottom: 20px;
    }
    .empty-cart h3 {
        margin-bottom: 10px;
    }

    /* Alerts */
    .fitstore-alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .fitstore-alert.success {
        background-color: #d4edda;
        color: #155724;
    }

    @media (max-width: 768px) {
        .cart-item {
            flex-wrap: wrap;
            padding: 15px;
        }
        .item-product, 
        .item-price,
        .item-quantity,
        .item-total,
        .item-actions {
            flex: 1 0 100%;
            margin-bottom: 15px;
            text-align: left;
        }
        .item-actions {
            text-align: right;
            margin-bottom: 0;
        }
        .cart-actions {
            flex-direction: column;
        }
    }
    /* Add new styles for update status */
    .update-status {
        font-size: 12px;
        height: 18px;
        margin-top: 5px;
        text-align: center;
    }
    
    .update-status.updating {
        color: #007bff;
    }
    
    .update-status.success {
        color: #28a745;
    }
    
    .update-status.error {
        color: #dc3545;
    }
    
    .product-stock {
        font-size: 12px;
        color: #666;
        margin-top: 3px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Function to show notification
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existingNotif = document.querySelector('.cart-notification');
        if (existingNotif) existingNotif.remove();
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `cart-notification ${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    
    // Function to update cart totals
    function updateCartTotals(subtotal, total) {
        document.getElementById('cart-subtotal').textContent = 'LE ' + subtotal;
        document.getElementById('cart-total').textContent = 'LE ' + total;
    }
    
    // Function to update cart count in header
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
        });
        // Store in localStorage for persistence
        localStorage.setItem('cartCount', count);
    }
    
    // Quantity buttons functionality
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            const cartId = input.dataset.cartId;
            const action = this.dataset.action;
            let value = parseInt(input.value);
            
            if (action === 'decrease') {
                value -= 1;
                // If value becomes 0 or less, it will be handled by updateCartItem
            } else if (action === 'increase') {
                value += 1;
            }
            
            input.value = value;
            updateCartItem(cartId, value);
        });
    });
    
    // Direct input change (when user types)
    document.querySelectorAll('.quantity-input').forEach(input => {
        let debounceTimer;
        
        input.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const cartId = this.dataset.cartId;
                let value = parseInt(this.value);
                
                // Validate min and max
                const min = parseInt(this.min);
                const max = parseInt(this.max);
                
                if (isNaN(value)) value = min;
                if (value < min) value = min;
                if (value > max) value = max;
                
                this.value = value;
                updateCartItem(cartId, value);
            }, 500); // 500ms debounce
        });
    });
    
    // Remove item functionality - FIXED
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.dataset.cartId;
            removeCartItem(cartId);
        });
    });
    
    // Update cart item via AJAX - MODIFIED to handle zero quantity
    function updateCartItem(cartId, quantity) {
        const statusElement = document.getElementById('update-status-' + cartId);
        const totalElement = document.getElementById('total-' + cartId);
        const input = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
        
        // Show updating status
        statusElement.textContent = 'Updating...';
        statusElement.className = 'update-status updating';
        
        // Disable input during update
        input.disabled = true;
        
        // Send AJAX request
        fetch(`/cart/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                quantity: quantity,
                _method: 'PUT'
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Check if item should be removed
                if (data.should_remove) {
                    // Remove item from DOM with animation
                    const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
                    cartItem.style.opacity = '0';
                    cartItem.style.transform = 'translateX(-100%)';
                    cartItem.style.transition = 'all 0.3s ease';
                    
                    setTimeout(() => {
                        cartItem.remove();
                        
                        // Update cart totals
                        updateCartTotals(data.cart_total, data.cart_total);
                        
                        // Update cart count
                        updateCartCount(data.cart_count);
                        
                        // Show notification
                        showNotification(data.message);
                        
                        // Check if cart is empty
                        if (document.querySelectorAll('.cart-item').length === 0) {
                            location.reload(); // Reload to show empty cart message
                        }
                    }, 300);
                } else {
                    // Update total for this item
                    totalElement.textContent = 'LE ' + data.item_total;
                    
                    // Update cart totals
                    updateCartTotals(data.cart_total, data.cart_total);
                    
                    // Update cart count
                    updateCartCount(data.cart_count);
                    
                    // Show success
                    statusElement.textContent = 'Updated ✓';
                    statusElement.className = 'update-status success';
                    
                    // Show notification
                    showNotification(data.message);
                    
                    // Hide status after 2 seconds
                    setTimeout(() => {
                        statusElement.textContent = '';
                        statusElement.className = 'update-status';
                    }, 2000);
                }
            } else {
                // Handle error from server
                statusElement.textContent = data.message || 'Error';
                statusElement.className = 'update-status error';
                
                // Revert input value
                const originalValue = input.defaultValue || 1;
                input.value = originalValue;
                
                setTimeout(() => {
                    statusElement.textContent = '';
                    statusElement.className = 'update-status';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            statusElement.textContent = 'Error updating';
            statusElement.className = 'update-status error';
            
            // Revert input value
            const originalValue = input.defaultValue || 1;
            input.value = originalValue;
            
            setTimeout(() => {
                statusElement.textContent = '';
                statusElement.className = 'update-status';
            }, 2000);
        })
        .finally(() => {
            // Re-enable input
            input.disabled = false;
        });
    }
    
// Remove cart item via AJAX - FIXED VERSION
function removeCartItem(cartId) {
    if (!confirm('Are you sure you want to remove this item from your cart?')) {
        return;
    }
    
    const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
    const removeBtn = cartItem.querySelector('.remove-btn');
    const statusElement = document.getElementById('update-status-' + cartId);
    
    // Show status and disable button
    if (statusElement) {
        statusElement.textContent = 'Removing...';
        statusElement.className = 'update-status updating';
    }
    removeBtn.disabled = true;
    removeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    // Use FormData to send proper DELETE request
    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Remove item from DOM with animation
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(-100%)';
            cartItem.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                cartItem.remove();
                
                // Update cart totals
                updateCartTotals(data.cart_total, data.cart_total);
                
                // Update cart count
                updateCartCount(data.cart_count);
                
                // Show notification
                showNotification(data.message);
                
                // Check if cart is empty
                const cartItems = document.querySelectorAll('.cart-item');
                if (cartItems.length === 0) {
                    // Reload to show empty cart message
                    setTimeout(() => location.reload(), 500);
                }
            }, 300);
        } else {
            // Handle error from server
            showNotification(data.message || 'Error removing item', 'error');
            if (statusElement) {
                statusElement.textContent = 'Error';
                statusElement.className = 'update-status error';
            }
            removeBtn.disabled = false;
            removeBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error removing item. Please try again.', 'error');
        if (statusElement) {
            statusElement.textContent = 'Error';
            statusElement.className = 'update-status error';
        }
        removeBtn.disabled = false;
        removeBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
    });
}
    // Checkout form AJAX handling
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const checkoutBtn = document.getElementById('checkout-btn');
            const originalText = checkoutBtn.textContent;
            
            // Disable button and show loading
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset cart count
                    updateCartCount(0);
                    
                    // Redirect to orders page
                    window.location.href = data.redirect_url;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error during checkout', 'error');
                checkoutBtn.disabled = false;
                checkoutBtn.textContent = originalText;
            });
        });
    }
    
    // Load initial cart count on page load
    updateCartCount({{ Auth::user()->carts()->count() }});
});
</script>
@endsection