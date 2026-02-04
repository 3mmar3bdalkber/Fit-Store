@extends('products/layout')

@section('content')
<div class="orders-container">
    <div class="orders-header">
        <h1 class="orders-title"> My Orders</h1>
        <p class="orders-subtitle">Track your purchases and order history</p>
    </div>
    
    @if(session('success'))
        <div class="success-notification">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error-notification">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3>No Orders Yet</h3>
            <p>Start shopping and your orders will appear here</p>
            <a href="{{ route('products.index') }}" class="start-shopping-btn">
                <i class="fas fa-shopping-cart"></i> Start Shopping
            </a>
        </div>
    @else
        <div class="stats-summary">
            <div class="stat-card">
                <div class="stat-number">{{ $orders->count() }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">LE {{ number_format($orders->sum('total'), 2) }}</div>
                <div class="stat-label">Total Spent</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $orders->sum(function($order) { return $order->orderItems->sum('quantity'); }) }}</div>
                <div class="stat-label">Items Purchased</div>
            </div>
        </div>

        <div class="orders-timeline">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <div class="order-info">
                            <div class="order-id">
                                <i class="fas fa-hashtag"></i>
                                Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="order-date">
                                <i class="far fa-calendar"></i>
                                {{ $order->created_at->format('M d, Y • h:i A') }}
                            </div>
                        </div>
                        <div class="order-status">
                            <span class="status-badge {{ strtolower($order->status) }}">
                                <i class="fas fa-check-circle"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                            <div class="order-total">
                                LE {{ number_format($order->total, 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="order-items-container">
                        <div class="items-header">
                            <span>Items ({{ $order->orderItems->count() }})</span>
                            <span>Price</span>
                        </div>
                        
                        @foreach($order->orderItems as $item)
                            <div class="order-item">
                                <div class="item-info">
                                    <div class="item-image">
                                        @if($item->product && $item->product->image1)
                                            <img src="{{ asset('product_images/' . $item->product->image1) }}" 
                                                 alt="{{ $item->product->name }}"
                                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNGOEY4RjgiLz48cGF0aCBkPSJNMzAgMjBDMzUgMjAgMzkgMjQgMzkgMzBDMzkgMzYgMzUgNDAgMzAgNDBDMjUgNDAgMjEgMzYgMjEgMzBDMjEgMjQgMjUgMjAgMzAgMjBaIiBmaWxsPSIjRDhEOEQ4Ii8+PC9zdmc+'">
                                        @else
                                            <div class="image-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="item-details">
                                        <h4 class="item-name">{{ $item->product->name ?? 'Product Unavailable' }}</h4>
                                        <div class="item-meta">
                                            <span class="item-color">
                                                <i class="fas fa-palette"></i>
                                                {{ $item->product->color ?? 'N/A' }}
                                            </span>
                                            <span class="item-quantity">
                                                <i class="fas fa-layer-group"></i>
                                                Qty: {{ $item->quantity }}
                                            </span>
                                            @if($item->sale > 0)
                                            <span class="item-sale">
                                                <i class="fas fa-tag"></i>
                                                {{ $item->sale }}% off
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="item-price">
                                    <div class="price-amount">
                                        LE {{ number_format($item->price * (1 - $item->sale/100) * $item->quantity, 2) }}
                                    </div>
                                    <div class="unit-price">
                                        LE {{ number_format($item->price * (1 - $item->sale/100), 2) }} each
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-footer">
                        <div class="order-actions">
                            <button class="action-btn reorder-btn" data-order-id="{{ $order->id }}">
                                <i class="fas fa-redo"></i> Reorder
                            </button>
                            <button class="action-btn details-btn" onclick="toggleOrderDetails({{ $order->id }})">
                                <i class="fas fa-chevron-down"></i> Details
                            </button>
                        </div>
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span>LE {{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Discount:</span>
                                <span class="discount">-LE {{ number_format($order->orderItems->sum(function($item) { return $item->price * ($item->sale/100) * $item->quantity; }), 2) }}</span>
                            </div>
                            <div class="summary-row total">
                                <span>Total:</span>
                                <span class="total-amount">LE {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="order-details" id="details-{{ $order->id }}" style="display: none;">
                        <div class="details-grid">
                            <div class="detail-item">
                                <h4><i class="fas fa-info-circle"></i> Order Information</h4>
                                <p><strong>Order ID:</strong> #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y • h:i A') }}</p>
                                <p><strong>Status:</strong> <span class="status-text {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span></p>
                            </div>
                            <div class="detail-item">
                                <h4><i class="fas fa-box"></i> Shipping Information</h4>
                                <p>Standard Shipping (3-5 business days)</p>
                                <p><strong>Delivery Status:</strong> Delivered</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($orders->hasPages())
        <div class="pagination-container">
            {{ $orders->links() }}
        </div>
        @endif
    @endif
</div>

<style>
    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
        min-height: calc(100vh - 380px);
        background-color: #f5f5dc;
    }

    /* Header */
    .orders-header {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(26, 26, 26, 0.1);
    }

    .orders-title {
        font-size: 2.8rem;
        color: #1a1a1a;
        margin-bottom: 10px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .orders-title i {
        color: #4CAF50;
        font-size: 2.5rem;
    }

    .orders-subtitle {
        font-size: 1.1rem;
        color: #555;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Notifications */
    .success-notification,
    .error-notification {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        animation: slideDown 0.3s ease;
    }

    .success-notification {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .error-notification {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 30px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        margin: 40px 0;
        border: 2px dashed #e8e8e8;
    }

    .empty-icon {
        font-size: 5rem;
        color: #d8d8d8;
        margin-bottom: 20px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .empty-state h3 {
        font-size: 2rem;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 30px;
        max-width: 500px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }

    .start-shopping-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .start-shopping-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        background: linear-gradient(135deg, #45a049 0%, #2E7D32 100%);
    }

    /* Stats Summary */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 25px 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .stat-label {
        color: #666;
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Orders Timeline */
    .orders-timeline {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Order Card */
    .order-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #e8e8e8;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        transform: translateY(-3px);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px 30px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e8e8e8;
    }

    .order-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .order-id {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-id i {
        color: #4CAF50;
    }

    .order-date {
        color: #666;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-status {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge.completed {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-badge.processing {
        background: linear-gradient(135deg, #cce5ff 0%, #b8daff 100%);
        color: #004085;
        border: 1px solid #b8daff;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .order-total {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a1a1a;
    }

    /* Order Items */
    .order-items-container {
        padding: 25px 30px;
    }

    .items-header {
        display: flex;
        justify-content: space-between;
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 600;
        color: #1a1a1a;
        font-size: 0.95rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #f8f8f8;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-info {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }

    .item-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        background: #f8f8f8;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e8e8e8;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        color: #ccc;
        font-size: 1.5rem;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 0.9rem;
        color: #666;
    }

    .item-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .item-meta i {
        font-size: 0.8rem;
    }

    .item-sale {
        color: #d82e2e;
        font-weight: 600;
    }

    .item-price {
        text-align: right;
        min-width: 150px;
    }

    .price-amount {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }

    .unit-price {
        font-size: 0.9rem;
        color: #666;
    }

    /* Order Footer */
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px 30px;
        background: #fafafa;
        border-top: 1px solid #e8e8e8;
    }

    .order-actions {
        display: flex;
        gap: 12px;
    }

    .action-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .reorder-btn {
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: white;
    }

    .reorder-btn:hover {
        background: linear-gradient(135deg, #333 0%, #4CAF50 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26, 26, 26, 0.2);
    }

    .details-btn {
        background: white;
        color: #1a1a1a;
        border: 2px solid #e8e8e8;
    }

    .details-btn:hover {
        background: #f8f8f8;
        border-color: #4CAF50;
        color: #4CAF50;
    }

    .order-summary {
        background: white;
        padding: 20px;
        border-radius: 10px;
        min-width: 250px;
        border: 1px solid #e8e8e8;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .summary-row:last-child {
        margin-bottom: 0;
    }

    .summary-row.total {
        padding-top: 10px;
        margin-top: 10px;
        border-top: 2px solid #e8e8e8;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .discount {
        color: #d82e2e;
    }

    .total-amount {
        color: #4CAF50;
    }

    /* Order Details */
    .order-details {
        padding: 0 30px 25px;
        animation: slideDown 0.3s ease;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        padding: 25px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e8e8e8;
    }

    .detail-item h4 {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .detail-item h4 i {
        color: #4CAF50;
    }

    .detail-item p {
        margin-bottom: 8px;
        color: #555;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .status-text {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-text.completed {
        background: #d4edda;
        color: #155724;
    }

    .status-text.processing {
        background: #cce5ff;
        color: #004085;
    }

    .status-text.pending {
        background: #fff3cd;
        color: #856404;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 40px;
        text-align: center;
    }

    .pagination-container .pagination {
        display: inline-flex;
        gap: 8px;
    }

    .pagination-container .page-link {
        padding: 10px 18px;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        color: #1a1a1a;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .pagination-container .page-link:hover {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: translateY(-2px);
    }

    .pagination-container .page-item.active .page-link {
        background: #1a1a1a;
        color: white;
        border-color: #1a1a1a;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .stats-summary {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .order-card-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .order-status {
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
        }
    }

    @media (max-width: 768px) {
        .orders-title {
            font-size: 2.2rem;
        }
        
        .stats-summary {
            grid-template-columns: 1fr;
        }
        
        .order-footer {
            flex-direction: column;
            gap: 20px;
        }
        
        .order-summary {
            width: 100%;
        }
        
        .item-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .item-image {
            width: 100%;
            height: 200px;
        }
        
        .order-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .item-price {
            text-align: left;
            width: 100%;
        }
        
        .details-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .orders-container {
            padding: 20px 15px;
        }
        
        .orders-title {
            font-size: 1.8rem;
        }
        
        .order-card-header,
        .order-items-container,
        .order-footer {
            padding: 20px;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
        
        .order-actions {
            flex-direction: column;
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle order details
    window.toggleOrderDetails = function(orderId) {
        const detailsElement = document.getElementById(`details-${orderId}`);
        const button = document.querySelector(`[onclick="toggleOrderDetails(${orderId})"]`);
        
        if (detailsElement.style.display === 'none' || detailsElement.style.display === '') {
            detailsElement.style.display = 'block';
            button.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Details';
            button.style.background = '#f8f8f8';
        } else {
            detailsElement.style.display = 'none';
            button.innerHTML = '<i class="fas fa-chevron-down"></i> Details';
            button.style.background = '';
        }
    };
    
    // Reorder functionality
    document.querySelectorAll('.reorder-btn').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            if (confirm('Add all items from this order to your cart?')) {
                // Show loading
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    // You would make an AJAX call here
                    // fetch(`/orders/${orderId}/reorder`, { method: 'POST' })
                    
                    // For now, show success message
                    showNotification('All items from order #' + orderId + ' added to cart!', 'success');
                    
                    // Update cart count (call your global function)
                    if (typeof updateCartCount === 'function') {
                        // Get current count and increment
                        const currentCount = parseInt(document.querySelector('.cart-count').textContent);
                        updateCartCount(currentCount + 1);
                    }
                    
                    // Reset button
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1500);
            }
        });
    });
    
    // Notification function
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Image error handling
    document.querySelectorAll('.item-image img').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            this.parentElement.innerHTML = '<div class="image-placeholder"><i class="fas fa-image"></i></div>';
        });
    });
    
    // Add CSS for animations if not already in layout
    if (!document.querySelector('#orders-animations')) {
        const style = document.createElement('style');
        style.id = 'orders-animations';
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
    }
});
</script>
@endsection