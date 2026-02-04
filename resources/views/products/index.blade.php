@extends('products/layout')

@push('style')
<style>
    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
        padding: 20px;
    }

    .page-header h1 {
        font-size: 2.8rem;
        color: #1a1a1a;
        margin-bottom: 10px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .page-header .subtitle {
        font-size: 1.1rem;
        color: #555;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Products Grid - Simpler Design */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Product Card - Simple Design */
    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        height: 480px;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* Image Container */
    .image-container {
        width: 100%;
        height: 320px; /* 75% of 480px */
        position: relative;
        overflow: hidden;
        background: #f8f8f8;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* Sale Badge */
    .sale-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #d82e2e;
        color: white;
        text-align: center;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: bold;
        border-radius: 4px;
        z-index: 2;
    }

    /* Hover Actions */
    .hover-actions {
        position: absolute;
        bottom: -50px;
        right: 0;
        width: 100%;
        background-color: #FFD700;
        text-align: center;
        padding: 15px 0;
        z-index: 3;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .image-container:hover .hover-actions {
        opacity: 1;
        bottom: 0;
    }

    .wishlist-button {
        position: absolute;
        top: 10px;
        left: -40px;
        z-index: 2;
        transition: all 0.3s ease;
        opacity: 0;
    }

    .image-container:hover .wishlist-button {
        opacity: 1;
        left: 10px;
    }

    /* Product Info */
    .product-info {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0 0 5px 0;
        line-height: 1.3;
    }

    .product-color {
        font-size: 14px;
        color: #666;
        margin: 0 0 10px 0;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: auto 0 0 0;
    }

    .current-price {
        font-weight: bold;
        font-size: 18px;
        color: #1a1a1a;
    }

    .original-price {
        color: #999;
        text-decoration: line-through;
        font-size: 14px;
    }

    /* Action Buttons */
    .action-btn {
        width: 100%;
        height: 100%;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        color: black;
        font-weight: 600;
        transition: all 0.3s;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-btn:hover {
        background-color: rgba(255, 215, 0, 0.9);
    }

    .action-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .action-btn.added {
        background-color: #28a745;
        color: white;
    }

    .wishlist-icon {
        width: 30px;
        height: 30px;
        transition: transform 0.3s;
    }

    .wishlist-icon:hover {
        transform: scale(1.1);
    }

    /* Admin Controls */
    .admin-controls {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .btn-admin {
        flex: 1;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-edit {
        background-color: #1a1a1a;
        color: white;
    }

    .btn-edit:hover {
        background-color: #333;
        transform: translateY(-2px);
    }

    .btn-delete {
        background-color: #d82e2e;
        color: white;
    }

    .btn-delete:hover {
        background-color: #b82525;
        transform: translateY(-2px);
    }

    /* Collection Badge */
    .collection-badge {
        display: inline-block;
        padding: 2px 8px;
        background: #f0f0f0;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 5px;
        color: #666;
    }

    /* Stats Bar */
    .stats-bar {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: 8px;
        margin: 20px auto 40px;
        max-width: 1000px;
        gap: 30px;
        flex-wrap: wrap;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a1a;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #555;
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 1.8rem;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
        max-width: 500px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 15px;
        }
        
        .product-card {
            height: 450px;
        }
        
        .image-container {
            height: 280px;
        }
        
        .page-header h1 {
            font-size: 2.2rem;
        }
        
        .stats-bar {
            gap: 15px;
            padding: 15px;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .admin-controls {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .products-grid {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .page-header h1 {
            font-size: 1.8rem;
        }
        
        .stats-bar {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Our Collection</h1>
    <p class="subtitle">Discover premium fashion pieces curated just for you</p>
    
    @auth
        @if(auth()->user()->role === 'admin')
        <div style="margin-top: 15px;">
            <span style="background: #1a1a1a; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-crown"></i> Admin Mode
            </span>
        </div>
        @endif
    @endauth
</div>

@auth
    @if(auth()->user()->role === 'admin')
    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-number">{{ $products->count() }}</span>
            <span class="stat-label">Total Products</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ $products->where('sale', '>', 0)->count() }}</span>
            <span class="stat-label">On Sale</span>
        </div>
        <div class="stat-item">
            <a href="{{ route('admin.products.create') }}" 
               style="background: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>
    @endif
@endauth

<div class="products-grid">
    @foreach($products as $product)
    <div class="product-card">
        <div class="image-container">
            <img src="{{ asset('product_images/' . $product->image1) }}" 
                 alt="{{ $product->name }}"
                 class="product-image"
                 onmouseover="this.src='{{ asset('product_images/' . $product->image2) }}'"
                 onmouseout="this.src='{{ asset('product_images/' . $product->image1) }}'">
            
            @if($product->sale > 0)
            <div class="sale-badge">
                {{ $product->sale }}% OFF
            </div>
            @endif

            <!-- Add to Cart Button -->
            <div class="hover-actions">
                @auth
                <form action="{{ route('cart.store', $product) }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="action-btn" data-product-id="{{ $product->id }}">
                        <i class="fas fa-cart-plus"></i> Add To Cart
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="action-btn" style="text-decoration: none;">
                    <i class="fas fa-sign-in-alt"></i> Login to Shop
                </a>
                @endauth
            </div>

            <!-- Wishlist Button -->
            <div class="wishlist-button">
                @auth
                <form action="{{ route('wishlist.store', $product->id) }}" method="POST" class="wishlist-form">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; padding: 5px;">
                        <img src="{{ asset('home img&vid/fav.png') }}" alt="fav" class="wishlist-icon">
                        <span style="margin-left: 5px; font-size: 12px; color: #333;">Add to fav</span>
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" style="display: flex; align-items: center; text-decoration: none; padding: 5px;">
                    <img src="{{ asset('home img&vid/fav.png') }}" alt="fav" class="wishlist-icon">
                    <span style="margin-left: 5px; font-size: 12px; color: #333;">Login to fav</span>
                </a>
                @endauth
            </div>
        </div>
        
        <div class="product-info">
            <h3 class="product-name">{{ $product->name }}</h3>
            <div class="product-color">
                {{ $product->color }}
                @if($product->collection)
                <span class="collection-badge">
                    {{ strtoupper($product->collection) }}
                </span>
                @endif
            </div>
            
            <div class="product-price">
                @if($product->sale > 0)
                <span class="current-price">
                    LE {{ number_format($product->price - ($product->price * $product->sale/100), 2) }}
                </span>
                <span class="original-price">
                    LE {{ number_format($product->price, 2) }}
                </span>
                @else
                <span class="current-price">
                    LE {{ number_format($product->price, 2) }}
                </span>
                @endif
            </div>
            
            @auth
                @if(auth()->user()->role === 'admin')
                <div class="admin-controls">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-admin btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="delete-product-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-delete">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </div>
                @endif
            @endauth
        </div>
    </div>
    @endforeach
    
    @if($products->count() === 0)
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-box-open"></i>
        </div>
        <h3>No Products Found</h3>
        <p>Our collection is currently empty. Check back soon for new arrivals!</p>
        @auth
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.products.create') }}" 
               style="background: #1a1a1a; color: white; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block;">
                <i class="fas fa-plus"></i> Add First Product
            </a>
            @endif
        @endauth
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Function to show toast notification
    function showToast(message, type = 'success') {
        // Remove existing toast
        const existingToast = document.querySelector('.custom-toast');
        if (existingToast) existingToast.remove();
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `custom-toast ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Add styles
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#4CAF50' : '#d82e2e'};
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            max-width: 350px;
        `;
        
        document.body.appendChild(toast);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .toast-content {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }
        .toast-content i {
            font-size: 1.2rem;
        }
    `;
    document.head.appendChild(style);
    
    // Add to cart functionality
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.action-btn');
            const originalHTML = button.innerHTML;
            const productName = this.closest('.product-card').querySelector('.product-name').textContent;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            button.disabled = true;
            
            // Create FormData
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count using global function
                    if (typeof updateCartCount === 'function') {
                        updateCartCount(data.cart_count);
                    }
                    
                    // Show success message
                    showToast('✓ Added to cart: ' + productName);
                    
                    // Button success animation
                    button.innerHTML = '<i class="fas fa-check"></i> Added!';
                    button.classList.add('added');
                    
                    // Revert button after 2 seconds
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalHTML;
                        button.classList.remove('added');
                    }, 2000);
                } else {
                    // Handle error from server
                    showToast('✗ ' + (data.message || 'Error adding to cart'), 'error');
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('✗ Network error. Please try again.', 'error');
                button.disabled = false;
                button.innerHTML = originalHTML;
            });
        });
    });
    
    // Add to wishlist functionality - FIXED
 // In your Blade template JavaScript
document.querySelectorAll('.wishlist-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const button = this.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        
        // Show loading state
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        // Send POST request with proper FormData
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showToast('✓ Added to wishlist!');
                
                // Update button state
                button.innerHTML = '<i class="fas fa-heart" style="color: #d82e2e;"></i> Added!';
                
                // Revert after 2 seconds
                setTimeout(() => {
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                }, 2000);
            } else {
                // If it's already in wishlist, show a friendly message
                if (data.message && (data.message.includes('already') || data.message.includes('already in your wishlist'))) {
                    showToast('✓ Already in wishlist!');
                } else {
                    showToast('✗ ' + (data.message || 'Error adding to wishlist'), 'error');
                }
                button.disabled = false;
                button.innerHTML = originalHTML;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('✗ Network error. Please try again.', 'error');
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    });
});
    // Delete product functionality
    document.querySelectorAll('.delete-product-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                return;
            }
            
            const button = this.querySelector('.btn-delete');
            const originalHTML = button.innerHTML;
            const productCard = this.closest('.product-card');
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Animate removal
                    productCard.style.opacity = '0';
                    productCard.style.transform = 'scale(0.8)';
                    productCard.style.transition = 'all 0.3s ease';
                    
                    setTimeout(() => {
                        productCard.remove();
                        showToast('✓ Product deleted successfully');
                        
                        // Check if we need to show empty state
                        if (document.querySelectorAll('.product-card').length === 0) {
                            location.reload();
                        }
                    }, 300);
                } else {
                    showToast('✗ ' + (data.message || 'Error deleting product'), 'error');
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('✗ Error deleting product', 'error');
                button.disabled = false;
                button.innerHTML = originalHTML;
            });
        });
    });
    
    // Image loading error handling
    document.querySelectorAll('.product-image').forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjZjhmOGY4Ii8+CjxwYXRoIGQ9Ik03NSAxMDBDODggODAgMTEyIDgwIDEyNSAxMDBDMTM4IDEyMCAxNjIgMTIwIDE3NSAxMDBDMTg4IDgwIDIwMCA1MCAxNzUgMjVDMTUwIDAgMTI1IDAgMTAwIDI1Qzc1IDUwIDg4IDgwIDc1IDEwMCIgZmlsbD0iI2Q4ZDhkOCIvPgo8cGF0aCBkPSJNNzUgMTAwQzg4IDEyMCAxMTIgMTIwIDEyNSAxMDBDMTM4IDgwIDE2MiA4MCAxNzUgMTAwQzE4OCAxMjAgMjAwIDE1MCAxNzUgMTc1QzE1MCAyMDAgMTI1IDIwMCAxMDAgMTc1Qzc1IDE1MCA4OCAxMjAgNzUgMTAwWiIgZmlsbD0iI2MzYzNjMyIvPgo8L3N2Zz4K';
        });
    });
});
</script>
@endpush