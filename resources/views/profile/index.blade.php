@extends('products/layout')

@section('content')
<div class="profile-container">
    <div class="profile-sidebar">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2 class="profile-name">{{ Auth::user()->name }}</h2>
            <p class="profile-email">{{ Auth::user()->email }}</p>
            <div class="profile-role">
                <span class="role-badge {{ Auth::user()->role === 'admin' ? 'admin' : 'customer' }}">
                    <i class="fas fa-{{ Auth::user()->role === 'admin' ? 'crown' : 'user' }}"></i>
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </div>
        
        <nav class="profile-nav">
            <a href="#orders" class="nav-link active" data-tab="orders">
                <i class="fas fa-shopping-bag"></i>
                <span>My Orders</span>
                <span class="badge">{{ $orders->count() }}</span>
            </a>
            <a href="#wishlist" class="nav-link" data-tab="wishlist">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
                <span class="badge">{{ $wishlistCount ?? 0 }}</span>
            </a>
            <a href="#settings" class="nav-link" data-tab="settings">
                <i class="fas fa-cog"></i>
                <span>Account Settings</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="nav-link logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </nav>
    </div>
    
    <div class="profile-content">
        <!-- Orders Tab -->
        <div class="tab-content active" id="orders-tab">
            <div class="tab-header">
                <h3><i class="fas fa-shopping-bag"></i> Order History</h3>
                <p>Track and manage your purchases</p>
            </div>
            
            @if($orders->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h4>No Orders Yet</h4>
                    <p>Start shopping and your orders will appear here</p>
                    <a href="{{ route('products.index') }}" class="primary-btn">
                        <i class="fas fa-shopping-cart"></i> Start Shopping
                    </a>
                </div>
            @else
                <div class="orders-summary">
                    <div class="summary-card">
                        <div class="summary-icon" style="background: #e3f2fd;">
                            <i class="fas fa-receipt" style="color: #1976d2;"></i>
                        </div>
                        <div class="summary-info">
                            <h4>{{ $orders->count() }}</h4>
                            <p>Total Orders</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon" style="background: #e8f5e9;">
                            <i class="fas fa-coins" style="color: #388e3c;"></i>
                        </div>
                        <div class="summary-info">
                            <h4>LE {{ number_format($orders->sum('total'), 2) }}</h4>
                            <p>Total Spent</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon" style="background: #fff3e0;">
                            <i class="fas fa-box" style="color: #f57c00;"></i>
                        </div>
                        <div class="summary-info">
                            <h4>{{ $totalItems }}</h4>
                            <p>Items Purchased</p>
                        </div>
                    </div>
                </div>
                
                <div class="orders-list">
                    @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-card-header">
                            <div>
                                <h4>Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h4>
                                <p class="order-date">
                                    <i class="far fa-calendar"></i>
                                    {{ $order->created_at->format('M d, Y • h:i A') }}
                                </p>
                            </div>
                            <div class="order-status">
                                <span class="status-badge completed">
                                    <i class="fas fa-check-circle"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="order-total">LE {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="order-items-preview">
                            @foreach($order->orderItems->take(2) as $item)
                            <div class="preview-item">
                                @if($item->product && $item->product->image1)
                                <img src="{{ asset('product_images/' . $item->product->image1) }}" 
                                     alt="{{ $item->product->name }}"
                                     class="preview-image">
                                @else
                                <div class="preview-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                                @endif
                                <div class="preview-details">
                                    <h5>{{ $item->product->name ?? 'Product' }}</h5>
                                    <p>Qty: {{ $item->quantity }} × LE {{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($order->orderItems->count() > 2)
                            <div class="more-items">
                                +{{ $order->orderItems->count() - 2 }} more items
                            </div>
                            @endif
                        </div>
                        
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order) }}" class="action-btn view-btn">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <button class="action-btn reorder-btn" onclick="reorder({{ $order->id }})">
                                <i class="fas fa-redo"></i> Reorder All
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($orders->hasPages())
                <div class="pagination-wrapper">
                    {{ $orders->links() }}
                </div>
                @endif
            @endif
        </div>
        
        <!-- Wishlist Tab -->
        <div class="tab-content" id="wishlist-tab">
            <div class="tab-header">
                <h3><i class="fas fa-heart"></i> My Wishlist</h3>
                <p>Your saved items</p>
            </div>
            <!-- Add wishlist content here -->
        </div>
        
        <!-- Settings Tab -->
        <div class="tab-content" id="settings-tab">
            <div class="tab-header">
                <h3><i class="fas fa-cog"></i> Account Settings</h3>
                <p>Manage your account information</p>
            </div>
            <!-- Add settings content here -->
        </div>
    </div>
</div>

<style>
    .profile-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
        min-height: calc(100vh - 380px);
        background-color: #f5f5dc;
    }

    /* Sidebar */
    .profile-sidebar {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        padding: 25px;
        height: fit-content;
        position: sticky;
        top: 30px;
    }

    .profile-header {
        text-align: center;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e8e8e8;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: white;
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 5px;
    }

    .profile-email {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 15px;
    }

    .profile-role .role-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .role-badge.admin {
        background: linear-gradient(135deg, #ffd700 0%, #ffcc00 100%);
        color: #333;
    }

    .role-badge.customer {
        background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
        color: white;
    }

    /* Navigation */
    .profile-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        text-decoration: none;
        color: #555;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
        position: relative;
    }

    .nav-link:hover {
        background: #f8f9fa;
        color: #1a1a1a;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
        color: white;
    }

    .nav-link.active .badge {
        background: white;
        color: #4CAF50;
    }

    .nav-link i {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .badge {
        margin-left: auto;
        background: #e8e8e8;
        color: #666;
        padding: 4px 10px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        min-width: 30px;
        text-align: center;
    }

    .logout-form {
        margin-top: 10px;
    }

    .logout-btn {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-family: inherit;
        font-size: inherit;
    }

    .logout-btn:hover {
        background: #ffeaea;
        color: #dc3545;
    }

    /* Profile Content */
    .profile-content {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        padding: 30px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .tab-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e8e8e8;
    }

    .tab-header h3 {
        font-size: 1.8rem;
        color: #1a1a1a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .tab-header p {
        color: #666;
        font-size: 1rem;
    }

    /* Orders Summary */
    .orders-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .summary-info h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }

    .summary-info p {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
    }

    /* Orders List */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        border-color: #4CAF50;
        box-shadow: 0 5px 20px rgba(76, 175, 80, 0.1);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-card-header h4 {
        font-size: 1.2rem;
        color: #1a1a1a;
        margin: 0;
    }

    .order-date {
        color: #666;
        font-size: 0.9rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .order-status {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-badge.completed {
        background: #d4edda;
        color: #155724;
    }

    .order-total {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Order Items Preview */
    .order-items-preview {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .preview-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .preview-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
    }

    .preview-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: #e8e8e8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
    }

    .preview-details h5 {
        font-size: 0.95rem;
        color: #1a1a1a;
        margin: 0 0 4px 0;
    }

    .preview-details p {
        font-size: 0.85rem;
        color: #666;
        margin: 0;
    }

    .more-items {
        text-align: center;
        padding: 8px;
        color: #4CAF50;
        font-weight: 500;
        background: rgba(76, 175, 80, 0.1);
        border-radius: 6px;
        margin-top: 5px;
    }

    /* Order Actions */
    .order-actions {
        display: flex;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }

    .action-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .view-btn {
        background: #1a1a1a;
        color: white;
    }

    .view-btn:hover {
        background: #333;
        transform: translateY(-2px);
    }

    .reorder-btn {
        background: #4CAF50;
        color: white;
    }

    .reorder-btn:hover {
        background: #388E3C;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 30px;
    }

    .empty-icon {
        font-size: 4rem;
        color: #d8d8d8;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        font-size: 1.5rem;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 25px;
        max-width: 400px;
        margin: 0 auto 25px;
    }

    .primary-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 28px;
        background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(76, 175, 80, 0.3);
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 40px;
        text-align: center;
    }

    .pagination-wrapper .pagination {
        display: inline-flex;
        gap: 8px;
        list-style: none;
        padding: 0;
    }

    .pagination-wrapper .page-link {
        padding: 10px 18px;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        color: #1a1a1a;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        background: white;
    }

    .pagination-wrapper .page-link:hover {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: translateY(-2px);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: #1a1a1a;
        color: white;
        border-color: #1a1a1a;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .profile-container {
            grid-template-columns: 1fr;
        }
        
        .profile-sidebar {
            position: static;
        }
        
        .orders-summary {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 20px 15px;
        }
        
        .profile-content,
        .profile-sidebar {
            padding: 20px;
        }
        
        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .order-status {
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
        }
        
        .order-actions {
            flex-direction: column;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const navLinks = document.querySelectorAll('.nav-link');
    const tabContents = document.querySelectorAll('.tab-content');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links and tabs
            navLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(tab => tab.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Show corresponding tab
            const tabId = this.dataset.tab;
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });
    
    // Reorder functionality
    window.reorder = function(orderId) {
        if (confirm('Add all items from this order to your cart?')) {
            // Show loading
            const btn = event.target.closest('.reorder-btn');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            btn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // You would make an AJAX call here
                // fetch(`/orders/${orderId}/reorder`, { method: 'POST' })
                
                // For now, show success message
                showNotification('Items added to cart successfully!', 'success');
                
                // Update cart count
                if (typeof updateCartCount === 'function') {
                    const currentCount = parseInt(document.querySelector('.cart-count').textContent);
                    updateCartCount(currentCount + 1);
                }
                
                // Reset button
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }, 1500);
        }
    };
    
    // Notification function
    function showNotification(message, type = 'success') {
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
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Add animation styles
    if (!document.querySelector('#profile-animations')) {
        const style = document.createElement('style');
        style.id = 'profile-animations';
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