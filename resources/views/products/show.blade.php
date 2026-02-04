@extends('products/layout')

@section('content')
<div class="container mt-5">
    <h2>Product Details</h2>

    <div class="card" style="width: 25rem;">
        <img src="{{ asset('product_images/'.$product->image1) }}" class="card-img-top" alt="{{ $product->name }}">
        <div class="card-body">
            <h4 class="card-title">{{ $product->name }}</h4>
            <p class="card-text"><strong>Color:</strong> {{ $product->color }}</p>
            <p class="card-text"><strong>Price:</strong> LE {{ number_format($product->price, 2) }}</p>
            <p class="card-text"><strong>Discount:</strong> {{ $product->sale }}%</p>
            
            @if($product->image2)
                <h5>Second Image:</h5>
                <img src="{{ asset('product_images/'.$product->image2) }}" width="200" class="mt-2">
            @endif

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
