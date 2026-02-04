@extends('products/layout')

@push('style')
<style>
    :root {
        --primary-color: black;
        --primary-dark: #3a56d5;
        --success-color: #10b981;
        --success-dark: #0da271;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --dark-color: #1f2937;
        --light-color: #f9fafb;
        --border-color: #e5e7eb;
        --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .edit-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .edit-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        padding: 2rem;
        border-radius: 16px 16px 0 0;
        color: white;
        box-shadow: var(--shadow);
    }

    .edit-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .edit-header p {
        opacity: 0.9;
        margin: 8px 0 0 0;
        font-size: 15px;
    }

    .edit-card {
        background: white;
        border-radius: 0 0 16px 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .edit-body {
        padding: 2.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-full-width {
        grid-column: 1 / -1;
    }

    .form-group {
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label i {
        margin-right: 8px;
        color: var(--primary-color);
    }

    .form-control, .form-select {
        width: 100%;
        padding: 12px 16px;
        font-size: 15px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        background: white;
        transition: var(--transition);
        outline: none;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .image-upload-container {
        border: 2px dashed var(--border-color);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: var(--transition);
        background: var(--light-color);
    }

    .image-upload-container:hover {
        border-color: var(--primary-color);
        background: #f8fafc;
    }

    .image-upload-container label {
        cursor: pointer;
        display: block;
    }

    .image-upload-container i {
        font-size: 48px;
        color: var(--primary-color);
        margin-bottom: 12px;
    }

    .image-upload-text {
        color: var(--dark-color);
        font-weight: 500;
        margin-bottom: 8px;
    }

    .image-upload-subtext {
        color: #6b7280;
        font-size: 13px;
    }

    .current-image {
        margin-top: 20px;
        text-align: center;
    }

    .current-image-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid var(--border-color);
        transition: var(--transition);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .image-preview:hover {
        transform: scale(1.05);
        border-color: var(--primary-color);
    }

    .alert-container {
        margin-bottom: 2rem;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: none;
        border-radius: 10px;
        padding: 1.25rem;
        border-left: 4px solid var(--danger-color);
        color: var(--dark-color);
    }

    .alert-danger strong {
        color: var(--danger-color);
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .error-list {
        list-style: none;
        padding-left: 24px;
        margin: 0;
    }

    .error-list li {
        position: relative;
        padding: 4px 0;
        color: #7f1d1d;
    }

    .error-list li:before {
        content: "•";
        color: var(--danger-color);
        font-weight: bold;
        position: absolute;
        left: -15px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--border-color);
    }

    .btn {
        padding: 12px 32px;
        font-size: 15px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(74, 108, 247, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(74, 108, 247, 0.4);
    }

    .btn-secondary {
        background: white;
        color: var(--dark-color);
        border: 2px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--light-color);
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .price-container {
        position: relative;
    }

    .price-prefix {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-weight: 500;
    }

    .price-input {
        padding-left: 40px;
    }

    .sale-container {
        position: relative;
    }

    .sale-suffix {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
        font-weight: 600;
    }

    .sale-input {
        padding-right: 40px;
    }

    .form-tips {
        font-size: 12px;
        color: #6b7280;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-tips i {
        color: var(--warning-color);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .edit-body {
            padding: 1.5rem;
        }
        
        .edit-header {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-container">
    <!-- Header Section -->
    <div class="edit-header">
        <h1>
            <i class="fas fa-edit"></i>
            Edit Product
        </h1>
        <p>Update product details and images</p>
    </div>

    <!-- Form Card -->
    <div class="edit-card">
        <div class="edit-body">
            <!-- Error Messages -->
            @if ($errors->any())
            <div class="alert-container">
                <div class="alert-danger">
                    <strong>
                        <i class="fas fa-exclamation-triangle"></i>
                        Please fix the following errors
                    </strong>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Product Name -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tag"></i> Product Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $product->name) }}" 
                               class="form-control" 
                               placeholder="Enter product name"
                               required>
                        <div class="form-tips">
                            <i class="fas fa-lightbulb"></i> Be descriptive and clear
                        </div>
                    </div>

                    <!-- Color -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-palette"></i> Color
                        </label>
                        <input type="text" 
                               name="color" 
                               id="color" 
                               value="{{ old('color', $product->color) }}" 
                               class="form-control" 
                               placeholder="e.g., Midnight Black"
                               required>
                        <div class="form-tips">
                            <i class="fas fa-lightbulb"></i> Use common color names
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-money-bill-wave"></i> Price
                        </label>
                        <div class="price-container">
                            <span class="price-prefix">LE</span>
                            <input type="number" 
                                   name="price" 
                                   id="price" 
                                   step="0.01" 
                                   min="0"
                                   value="{{ old('price', $product->price) }}" 
                                   class="form-control price-input" 
                                   placeholder="0.00"
                                   required>
                        </div>
                    </div>

                    <!-- Sale Percentage -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-percentage"></i> Sale Discount
                        </label>
                        <div class="sale-container">
                            <input type="number" 
                                   name="sale" 
                                   id="sale" 
                                   min="0" 
                                   max="100" 
                                   value="{{ old('sale', $product->sale) }}" 
                                   class="form-control sale-input" 
                                   placeholder="0">
                            <span class="sale-suffix">%</span>
                        </div>
                        <div class="form-tips">
                            <i class="fas fa-lightbulb"></i> Leave at 0 for no discount
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-boxes"></i> Stock Quantity
                        </label>
                        <input type="number" 
                               name="quantity" 
                               id="quantity" 
                               min="1"
                               value="{{ old('quantity', $product->quantity) }}" 
                               class="form-control" 
                               placeholder="Available units"
                               required>
                    </div>

                    <!-- Collection -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-layer-group"></i> Collection
                        </label>
                        <select name="collection" id="collection" class="form-select" required>
                            <option value="">Select Collection</option>
                            <option value="summer" {{ old('collection', $product->collection) == 'summer' ? 'selected' : '' }}>
                                🌞 Summer Collection
                            </option>
                            <option value="winter" {{ old('collection', $product->collection) == 'winter' ? 'selected' : '' }}>
                                ❄️ Winter Collection
                            </option>
                        </select>
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user-friends"></i> Gender
                        </label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="">Select Target Gender</option>
                            <option value="male" {{ old('gender', $product->gender) == 'male' ? 'selected' : '' }}>
                                👨 Male
                            </option>
                            <option value="female" {{ old('gender', $product->gender) == 'female' ? 'selected' : '' }}>
                                👩 Female
                            </option>
                            <option value="unisex" {{ old('gender', $product->gender) == 'unisex' ? 'selected' : '' }}>
                                👥 Unisex
                            </option>
                        </select>
                    </div>

                    <!-- Category (Full Width) -->
                    <div class="form-group form-full-width">
                        <label class="form-label">
                            <i class="fas fa-folder"></i> Category
                        </label>
                        <input type="text" 
                               name="category" 
                               id="category" 
                               value="{{ old('category', $product->category) }}" 
                               class="form-control" 
                               placeholder="e.g., T-Shirts, Jeans, Jackets"
                               required>
                        <div class="form-tips">
                            <i class="fas fa-lightbulb"></i> Helps with product organization
                        </div>
                    </div>

                    <!-- Main Image Upload -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-image"></i> Main Image
                        </label>
                        <div class="image-upload-container">
                            <label for="image1">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="image-upload-text">Upload Main Image</div>
                                <div class="image-upload-subtext">Click or drag & drop</div>
                                <input type="file" 
                                       name="image1" 
                                       id="image1" 
                                       class="d-none" 
                                       accept="image/*">
                            </label>
                        </div>
                        @if($product->image1)
                        <div class="current-image">
                            <div class="current-image-label">Current Image:</div>
                            <img src="{{ asset('product_images/' . $product->image1) }}" 
                                 alt="Current Main Image" 
                                 class="image-preview">
                        </div>
                        @endif
                    </div>

                    <!-- Hover Image Upload -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-exchange-alt"></i> Hover Image
                        </label>
                        <div class="image-upload-container">
                            <label for="image2">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="image-upload-text">Upload Hover Image</div>
                                <div class="image-upload-subtext">Shows on product hover</div>
                                <input type="file" 
                                       name="image2" 
                                       id="image2" 
                                       class="d-none" 
                                       accept="image/*">
                            </label>
                        </div>
                        @if($product->image2)
                        <div class="current-image">
                            <div class="current-image-label">Current Hover Image:</div>
                            <img src="{{ asset('product_images/' . $product->image2) }}" 
                                 alt="Current Hover Image" 
                                 class="image-preview">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview for file inputs
    const image1Input = document.getElementById('image1');
    const image2Input = document.getElementById('image2');
    
    // Add click handlers to image upload containers
    document.querySelectorAll('.image-upload-container').forEach(container => {
        container.addEventListener('click', function(e) {
            if (!e.target.matches('input')) {
                const input = this.querySelector('input[type="file"]');
                if (input) input.click();
            }
        });
    });
    
    // Handle image file selection
    [image1Input, image2Input].forEach(input => {
        if (input) {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const container = this.closest('.form-group').querySelector('.image-upload-container');
                    if (container) {
                        // Create image preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Remove current preview if exists
                            const currentPreview = container.parentElement.querySelector('.current-image');
                            if (currentPreview) {
                                currentPreview.remove();
                            }
                            
                            // Add new preview
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'current-image';
                            previewDiv.innerHTML = `
                                <div class="current-image-label">New Image Preview:</div>
                                <img src="${e.target.result}" class="image-preview" alt="New Image Preview">
                            `;
                            container.parentElement.appendChild(previewDiv);
                        };
                        reader.readAsDataURL(file);
                        
                        // Update upload container text
                        const textElement = container.querySelector('.image-upload-text');
                        if (textElement) {
                            textElement.textContent = 'Image Selected ✓';
                            textElement.style.color = 'var(--success-color)';
                        }
                    }
                }
            });
        }
    });
    
    // Sale percentage validation
    const saleInput = document.getElementById('sale');
    if (saleInput) {
        saleInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
        });
    }
    
    // Quantity validation
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('input', function() {
            if (this.value < 1) this.value = 1;
        });
    }
});
</script>
@endpush
@endsection