@extends('products/layout')

@push('style')
<style>
    .block {
        text-align: center;
        padding: 15px;
        margin-bottom: 30px;
        background-color: black;
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .container {
        position: relative;
        margin-top: 20px;
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        justify-content: center;
    }

    .card {
        width: 100%;
        height: 480px;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .imgCon {
        width: 100%;
        height: 75%;
        position: relative;
        overflow: hidden;
    }

    .product_img {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 0.5s ease, background-image 0.3s ease-in-out;
    }

    .card:hover .product_img {
        transform: scale(1.05);
    }

    .sale {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #3498db;
        color: white;
        text-align: center;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: bold;
        border-radius: 4px;
        z-index: 2;
    }

    .product-info {
        padding: 15px;
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
        font-size: 16px;
        margin: 0;
    }

    .original-price {
        color: #999;
        text-decoration: line-through;
        font-size: 14px;
    }

    .sale-price {
        color: #2c3e50;
        font-weight: bold;
        font-size: 18px;
    }

    .addTo {
        position: absolute;
        bottom: -50px;
        right: 0;
        width: 100%;
        background-color: #3498db;
        text-align: center;
        padding: 15px 0;
        font-size: 16px;
        font-weight: 600;
        z-index: 3;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .imgCon:hover .addTo {
        opacity: 1;
        bottom: 0;
    }

    .love_icon,
    .love {
        width: 30px;
        height: 30px;
    }

    .love {
        z-index: 2;
        position: absolute;
        top: 10px;
        left: -10px;
        transition: all 0.3s ease;
        opacity: 0;
        width: auto;
    }

    .imgCon:hover .love {
        opacity: 1;
        left: 10px;
    }

    .wordAdd {
        position: absolute;
        bottom: 5px;
        left: 35px;
        font-size: 12px;
        color: #333;
        white-space: nowrap;
    }

    .add-to-cart-btn {
        width: 100%;
        height: 100%;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .add-to-cart-btn:hover {
        background-color: rgba(52, 152, 219, 0.9);
    }

    .add-to-cart-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background-color: #95a5a6;
    }

    .add-to-cart-btn.added {
        background-color: #27ae60;
        color: white;
    }

    @media screen and (max-width: 1200px) {
        .container {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media screen and (max-width: 768px) {
        .container {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        
        .card {
            height: 450px;
        }
    }

    @media screen and (max-width: 600px) {
        .container {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .block {
            font-size: 20px;
            padding: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="block">Winter Collection</div>

<div class="container">
    @foreach($products as $product)
    @if($product->collection==="winter")
    <div class="card">
        <div class="imgCon">
            <div class="product_img"
                style="background-image: url('{{ asset('product_images/'.$product->image1) }}');"
                onmouseover="this.style.backgroundImage='url({{ asset('product_images/'.$product->image2) }})'"
                onmouseout="this.style.backgroundImage='url({{ asset('product_images/'.$product->image1) }})'">
            </div>
            
            @if($product->sale > 0)
            <div class="sale">sale {{$product->sale}}%</div>
            @endif

            <!-- Add to Cart Button -->
            <div class="addTo">
                @auth
                <form action="{{ route('cart.store', $product) }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" 
                            class="add-to-cart-btn"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}">
                        <i class="fas fa-snowflake"></i> Add To Cart
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="add-to-cart-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-sign-in-alt"></i> Login to Add To Cart
                </a>
                @endauth
            </div>

            <div class="love">
                @auth
                <form action="{{ route('wishlist.store', $product) }}" method="POST" class="wishlist-form">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center;">
                        <img src="{{asset('home img&vid/fav.png')}}" alt="fav" class="love_icon">
                        <span class="wordAdd">add to fav</span>
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" style="display: flex; align-items: center; text-decoration: none; color: #333;">
                    <img src="{{asset('home img&vid/fav.png')}}" alt="fav" class="love_icon">
                    <span class="wordAdd">login to fav</span>
                </a>
                @endauth
            </div>
        </div>
        
        <div class="product-info">
            <p class="product-name">{{$product->name}}</p>
            <p class="product-color">{{$product->color}}</p>
            <p class="product-price">
                @if($product->sale > 0)
                <span class="original-price">LE {{number_format($product->price,2)}}</span>
                <span class="sale-price">LE {{number_format($product->price - ($product->price * $product->sale/100), 2)}}</span>
                @else
                <span class="sale-price">LE {{number_format($product->price,2)}}</span>
                @endif
            </p>
        </div>
    </div>
    @endif
    @endforeach
    
    @if($products->where('collection', 'winter')->count() === 0)
    <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
        <h3>No winter products available at the moment.</h3>
        <p>Check back soon for our winter collection!</p>
        <a href="{{ route('products.index') }}" class="fitstore-btn primary" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            View All Products
        </a>
    </div>
    @endif
</div>

@if($products->where('collection', 'winter')->count() > 0)
<div style="text-align: center; margin-top: 40px; padding: 20px;">
    <p>Showing {{ $products->where('collection', 'winter')->count() }} winter products</p>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    console.log('CSRF Token:', csrfToken); // Debug log
    
    // Add to cart functionality with AJAX
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.add-to-cart-btn');
            const productId = button.dataset.productId;
            const productName = button.dataset.productName;
            
            console.log('Adding product:', productId, productName); // Debug log
            
            // Create FormData object
            const formData = new FormData(this);
            
            // Disable button to prevent multiple clicks
            button.disabled = true;
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            
            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status); // Debug log
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debug log
                if (data.success) {
                    // Update cart count using the global function from layout
                    if (typeof updateCartCount === 'function') {
                        updateCartCount(data.cart_count);
                    }
                    
                    // Show success message using global function
                    if (typeof showNotification === 'function') {
                        showNotification('✓ ' + data.message + ': ' + productName);
                    } else {
                        // Fallback notification
                        alert('Added to cart: ' + productName);
                    }
                    
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
                    const errorMsg = data.message || 'Error adding to cart';
                    console.error('Server error:', errorMsg);
                    
                    if (typeof showNotification === 'function') {
                        showNotification('✗ ' + errorMsg, 'error');
                    } else {
                        alert('Error: ' + errorMsg);
                    }
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                if (typeof showNotification === 'function') {
                    showNotification('✗ Error adding to cart. Please try again.', 'error');
                } else {
                    alert('Network error. Please try again.');
                }
                button.disabled = false;
                button.innerHTML = originalHTML;
            });
        });
    });
    
    // Wishlist form AJAX handling
    document.querySelectorAll('.wishlist-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const originalHTML = button.innerHTML;
            
            // Disable button during request
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (typeof showNotification === 'function') {
                        showNotification('✓ Added to wishlist!');
                    }
                    button.innerHTML = '<i class="fas fa-heart"></i> Added!';
                    
                    // Revert after 2 seconds
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalHTML;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                button.innerHTML = originalHTML;
            });
        });
    });
});
</script>
@endpush