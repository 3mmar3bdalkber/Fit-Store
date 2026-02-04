@extends('products/layout')

@section('content')
<div class="fitstore-container">
    <h2 class="fitstore-heading">Your Wishlist</h2>
    
    @if(session('success'))
        <div class="fitstore-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fitstore-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if($wishlists->isEmpty())
        <div class="empty-wishlist text-center py-5">
            <i class="fas fa-heart fa-4x mb-3"></i>
            <h4>Your wishlist is empty</h4>
            <p>Start adding products to your wishlist</p>
            <a href="{{ route('products.index') }}" class="fitstore-btn primary">Browse Collections</a>
        </div>
    @else
        <div class="wishlist-grid">
            @foreach($wishlists as $wishlist)
                @php $product = $wishlist->product; @endphp
                <div class="wishlist-card">
                    <div class="product-image-container">
                        <img src="{{ asset('product_images/'.$product->image1) }}" 
                             alt="{{ $product->name }}"
                             class="product-image"
                             onmouseover="this.src='{{ asset('product_images/'.$product->image2) }}'"
                             onmouseout="this.src='{{ asset('product_images/'.$product->image1) }}'">
                        
                        @if($product->sale > 0)
                            <div class="sale-badge">SALE {{$product->sale}}%</div>
                        @endif

                        <div class="wishlist-actions">
                            <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </form>
                            <form action="{{ route('cart.store', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="cart-btn">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-color">{{ $product->color }}</p>
                        <div class="product-price">
                            @if($product->sale > 0)
                                <span class="original-price">LE {{ number_format($product->price, 2) }}</span>
                                <span class="sale-price">LE {{ number_format($product->price - ($product->price * $product->sale / 100), 2) }}</span>
                            @else
                                <span class="current-price">LE {{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    /* Main Container */
    .fitstore-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Arial', sans-serif;
    }

    /* Collection Navigation */
    .collection-nav {
        display: flex;
        justify-content: center;
        gap: 20px;
        border-bottom: 1px solid #eee;
    }
    .collection-link {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        padding: 5px 10px;
    }
    .collection-link.active {
        color: #d82e2e;
        border-bottom: 2px solid #d82e2e;
    }

    /* Headings */
    .fitstore-heading {
        font-size: 28px;
        color: #333;
        margin: 30px 0 20px;
        text-align: center;
        font-weight: 700;
    }

    /* Wishlist Grid */
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    /* Wishlist Card */
    .wishlist-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Product Image */
    .product-image-container {
        position: relative;
        height: 300px;
        overflow: hidden;
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease;
    }

    /* Sale Badge */
    .sale-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #d82e2e;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 14px;
    }

    /* Product Info */
    .product-info {
        padding: 15px;
    }
    .product-name {
        font-size: 18px;
        margin-bottom: 5px;
        color: #333;
    }
    .product-color {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .product-price {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .original-price {
        text-decoration: line-through;
        color: #999;
    }
    .sale-price {
        color: #d82e2e;
        font-weight: bold;
    }
    .current-price {
        font-weight: bold;
        color: #333;
    }

    /* Wishlist Actions */
    .wishlist-actions {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        opacity: 0;
        transition: opacity 0.3s ease;
        background: rgba(255,255,255,0.9);
    }
    .wishlist-card:hover .wishlist-actions {
        opacity: 1;
    }
    .remove-btn, .cart-btn {
        flex: 1;
        padding: 10px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: 14px;
    }
    .remove-btn {
        background-color: #f8f8f8;
        color: #d82e2e;
    }
    .cart-btn {
        background-color: #d82e2e;
        color: white;
    }

    /* Newsletter */
    .newsletter-section {
        background-color: #f8f8f8;
        padding: 30px;
        text-align: center;
        margin-top: 50px;
        border-radius: 8px;
    }
    .newsletter-title {
        font-size: 24px;
        margin-bottom: 15px;
    }
    .newsletter-title strong {
        color: #d82e2e;
    }
    .newsletter-text {
        color: #666;
        margin-bottom: 20px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .newsletter-form {
        display: flex;
        max-width: 500px;
        margin: 0 auto;
    }
    .newsletter-form input {
        flex: 1;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px 0 0 4px;
    }
    .newsletter-form button {
        border-radius: 0 4px 4px 0;
    }

    /* Buttons */
    .fitstore-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .fitstore-btn.primary {
        background-color: #d82e2e;
        color: white;
    }
    .fitstore-btn.primary:hover {
        background-color: #b82525;
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
    .fitstore-alert.error {
        background-color: #f8d7da;
        color: #721c24;
    }

    /* Empty State */
    .empty-wishlist {
        padding: 40px 20px;
        background-color: #f8f8f8;
        border-radius: 8px;
    }
    .empty-wishlist i {
        color: #d82e2e;
    }
</style>
@endsection