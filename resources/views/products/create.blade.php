@extends('products/layout')

@push('style')
<style>
    /* Page Container */
    .admin-page-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 20px;
    }

    /* Form Container */
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Header */
    .form-header {
        background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
        padding: 30px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        animation: float 20s linear infinite;
    }

    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(-20px, -20px) rotate(360deg); }
    }

    .form-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .form-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Form Body */
    .form-body {
        padding: 40px;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Form Group */
    .form-group {
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2d3436;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label .required {
        color: #ff7675;
        margin-left: 4px;
    }

    /* Form Inputs */
    .form-input,
    .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #6c5ce7;
        background: white;
        box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1);
        transform: translateY(-2px);
    }

    .form-input::placeholder {
        color: #b2bec3;
    }

    /* File Input */
    .file-input-container {
        position: relative;
    }

    .file-input {
        position: absolute;
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: #f8f9fa;
        border: 2px dashed #e0e0e0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input-label:hover {
        background: #e8e8e8;
        border-color: #6c5ce7;
    }

    .file-input-label .icon {
        font-size: 1.5rem;
        color: #6c5ce7;
    }

    .file-input-label .text {
        flex: 1;
    }

    .file-input-label .text strong {
        display: block;
        color: #2d3436;
        margin-bottom: 4px;
    }

    .file-input-label .text span {
        font-size: 0.9rem;
        color: #636e72;
    }

    /* Image Preview */
    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .image-preview {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        min-height: 150px;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .image-preview .placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 150px;
        color: #b2bec3;
        font-size: 0.9rem;
    }

    .image-preview .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff7675;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-preview:hover .remove-btn {
        opacity: 1;
    }

    /* Full Width Fields */
    .full-width {
        grid-column: 1 / -1;
    }

    /* Error Messages */
    .error-message {
        color: #ff7675;
        font-size: 0.85rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .error-message::before {
        content: '⚠️';
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid #f1f2f6;
    }

    .form-btn {
        padding: 14px 32px;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
        color: white;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #00a085 0%, #008b74 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 184, 148, 0.3);
    }

    .btn-cancel {
        background: #f8f9fa;
        color: #636e72;
        border: 2px solid #e0e0e0;
    }

    .btn-cancel:hover {
        background: #e9ecef;
        border-color: #b2bec3;
        transform: translateY(-2px);
    }

    /* Loading State */
    .form-btn.loading {
        position: relative;
        color: transparent;
    }

    .form-btn.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Product Preview */
    .preview-section {
        margin-top: 30px;
        padding: 25px;
        background: #f8f9fa;
        border-radius: 16px;
        border-left: 4px solid #6c5ce7;
    }

    .preview-section h3 {
        color: #2d3436;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .preview-card {
        display: flex;
        gap: 20px;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .preview-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        background: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b2bec3;
    }

    .preview-info {
        flex: 1;
    }

    .preview-info h4 {
        margin: 0 0 8px 0;
        color: #2d3436;
    }

    .preview-info p {
        margin: 4px 0;
        color: #636e72;
        font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-page-container {
            padding: 20px 15px;
        }
        
        .form-body {
            padding: 25px;
        }
        
        .form-header {
            padding: 20px;
        }
        
        .form-header h1 {
            font-size: 2rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .form-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .image-preview-container {
            grid-template-columns: 1fr;
        }
        
        .preview-card {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-page-container">
    <div class="form-container">
        <div class="form-header">
            <h1>{{ isset($product) ? 'Edit Product' : 'Create New Product' }}</h1>
            <p>{{ isset($product) ? 'Update your product details below' : 'Fill in the details to add a new product to your store' }}</p>
        </div>
        
        <div class="form-body">
            <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  id="productForm">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <!-- Product Name -->
                    <div class="form-group">
                        <label class="form-label">Product Name <span class="required">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-input" 
                               value="{{ old('name', $product->name ?? '') }}"
                               placeholder="Enter product name"
                               required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div class="form-group">
                        <label class="form-label">Color <span class="required">*</span></label>
                        <input type="text" 
                               name="color" 
                               class="form-input" 
                               value="{{ old('color', $product->color ?? '') }}"
                               placeholder="e.g., Black, Red, Blue"
                               required>
                        @error('color')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label class="form-label">Price (LE) <span class="required">*</span></label>
                        <input type="number" 
                               name="price" 
                               class="form-input" 
                               value="{{ old('price', $product->price ?? '') }}"
                               placeholder="0.00"
                               step="0.01"
                               min="0"
                               required>
                        @error('price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sale Percentage -->
                    <div class="form-group">
                        <label class="form-label">Sale Percentage</label>
                        <input type="number" 
                               name="sale" 
                               class="form-input" 
                               value="{{ old('sale', $product->sale ?? 0) }}"
                               placeholder="0"
                               min="0"
                               max="100">
                        @error('sale')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Collection -->
                    <div class="form-group">
                        <label class="form-label">Collection</label>
                        <select name="collection" class="form-select">
                            <option value="">Select Collection</option>
                            <option value="summer" {{ old('collection', $product->collection ?? '') == 'summer' ? 'selected' : '' }}>Summer</option>
                            <option value="winter" {{ old('collection', $product->collection ?? '') == 'winter' ? 'selected' : '' }}>Winter</option>
                            <option value="latest" {{ old('collection', $product->collection ?? '') == 'latest' ? 'selected' : '' }}>Latest</option>
                        </select>
                        @error('collection')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="men" {{ old('gender', $product->gender ?? '') == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ old('gender', $product->gender ?? '') == 'women' ? 'selected' : '' }}>Women</option>
                            <option value="kids" {{ old('gender', $product->gender ?? '') == 'kids' ? 'selected' : '' }}>Kids</option>
                            <option value="unisex" {{ old('gender', $product->gender ?? '') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                        @error('gender')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="form-group full-width">
                        <label class="form-label">Category <span class="required">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="shirt" {{ old('category', $product->category ?? '') == 'shirt' ? 'selected' : '' }}>Shirt</option>
                            <option value="t-shirt" {{ old('category', $product->category ?? '') == 't-shirt' ? 'selected' : '' }}>T-Shirt</option>
                            <option value="polo" {{ old('category', $product->category ?? '') == 'polo' ? 'selected' : '' }}>Polo</option>
                            <option value="dress" {{ old('category', $product->category ?? '') == 'dress' ? 'selected' : '' }}>Dress</option>
                            <option value="jeans" {{ old('category', $product->category ?? '') == 'jeans' ? 'selected' : '' }}>Jeans</option>
                            <option value="pants" {{ old('category', $product->category ?? '') == 'pants' ? 'selected' : '' }}>Pants</option>
                            <option value="jogger" {{ old('category', $product->category ?? '') == 'jogger' ? 'selected' : '' }}>Jogger</option>
                            <option value="shoes" {{ old('category', $product->category ?? '') == 'shoes' ? 'selected' : '' }}>Shoes</option>
                            <option value="accessories" {{ old('category', $product->category ?? '') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                        </select>
                        @error('category')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="form-group">
                        <label class="form-label">Quantity <span class="required">*</span></label>
                        <input type="number" 
                               name="quantity" 
                               class="form-input" 
                               value="{{ old('quantity', $product->quantity ?? '') }}"
                               placeholder="0"
                               min="0"
                               required>
                        @error('quantity')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image Uploads -->
                <div class="form-group full-width">
                    <label class="form-label">Product Images</label>
                    
                    <div class="image-preview-container">
                        <!-- Image 1 -->
                        <div class="image-preview" id="previewImage1">
                            @if(isset($product) && $product->image1)
                                <img src="{{ asset('product_images/' . $product->image1) }}" alt="Image 1">
                                <button type="button" class="remove-btn" onclick="clearImage('image1')">×</button>
                            @else
                                <div class="placeholder">Image 1 Preview</div>
                            @endif
                        </div>
                        
                        <!-- Image 2 -->
                        <div class="image-preview" id="previewImage2">
                            @if(isset($product) && $product->image2)
                                <img src="{{ asset('product_images/' . $product->image2) }}" alt="Image 2">
                                <button type="button" class="remove-btn" onclick="clearImage('image2')">×</button>
                            @else
                                <div class="placeholder">Image 2 Preview</div>
                            @endif
                        </div>
                    </div>

                    <!-- Image 1 Upload -->
                    <div class="file-input-container">
                        <input type="file" 
                               name="image1" 
                               id="image1" 
                               class="file-input"
                               accept="image/*"
                               {{ !isset($product) ? 'required' : '' }}>
                        <label for="image1" class="file-input-label">
                            <span class="icon"></span>
                            <div class="text">
                                <strong>Primary Image</strong>
                                <span>Click to upload main product image</span>
                            </div>
                            <span class="browse">Browse</span>
                        </label>
                        @error('image1')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image 2 Upload -->
                    <div class="file-input-container" style="margin-top: 15px;">
                        <input type="file" 
                               name="image2" 
                               id="image2" 
                               class="file-input"
                               accept="image/*"
                               {{ !isset($product) ? 'required' : '' }}>
                        <label for="image2" class="file-input-label">
                            <span class="icon"></span>
                            <div class="text">
                                <strong>Secondary Image</strong>
                                <span>Click to upload hover/alternate image</span>
                            </div>
                            <span class="browse">Browse</span>
                        </label>
                        @error('image2')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Live Preview -->
                @if(isset($product))
                <div class="preview-section">
                    <h3><i class="fas fa-eye"></i> Live Preview</h3>
                    <div class="preview-card">
                        <div class="preview-image">
                            @if($product->image1)
                                <img src="{{ asset('product_images/' . $product->image1) }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            @else
                                <i class="fas fa-image" style="font-size: 2rem;"></i>
                            @endif
                        </div>
                        <div class="preview-info">
                            <h4>{{ $product->name }}</h4>
                            <p><strong>Color:</strong> {{ $product->color }}</p>
                            <p><strong>Price:</strong> LE {{ number_format($product->price, 2) }}</p>
                            @if($product->sale > 0)
                            <p><strong>Sale:</strong> {{ $product->sale }}% OFF</p>
                            @endif
                            <p><strong>Stock:</strong> {{ $product->quantity }} units</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('products.index') }}" class="form-btn btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="form-btn btn-submit" id="submitBtn">
                        <i class="fas fa-save"></i> {{ isset($product) ? 'Update Product' : 'Create Product' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        if (!input || !preview) return;
        
        input.addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-btn" onclick="clearImage('${inputId}')">×</button>
                    `;
                }
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Setup both image previews
    setupImagePreview('image1', 'previewImage1');
    setupImagePreview('image2', 'previewImage2');
    
    // Clear image function
    window.clearImage = function(inputId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById('preview' + inputId.charAt(0).toUpperCase() + inputId.slice(1));
        
        if (input) {
            input.value = '';
        }
        
        if (preview) {
            preview.innerHTML = '<div class="placeholder">' + (inputId === 'image1' ? 'Image 1 Preview' : 'Image 2 Preview') + '</div>';
        }
    };
    
    // Form submission handling
    const form = document.getElementById('productForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function() {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    }
    
    // Price calculation preview
    const priceInput = document.querySelector('input[name="price"]');
    const saleInput = document.querySelector('input[name="sale"]');
    
    if (priceInput && saleInput) {
        function updatePricePreview() {
            const price = parseFloat(priceInput.value) || 0;
            const sale = parseFloat(saleInput.value) || 0;
            const finalPrice = price - (price * sale / 100);
            
            // You could update a preview element here if needed
            console.log('Price Preview:', finalPrice.toFixed(2));
        }
        
        priceInput.addEventListener('input', updatePricePreview);
        saleInput.addEventListener('input', updatePricePreview);
    }
    
    // Auto-generate product name slug
    const nameInput = document.querySelector('input[name="name"]');
    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            // This is where you could auto-generate a slug or other metadata
            const name = this.value.trim();
            if (name) {
                console.log('Product name:', name);
                // You could auto-fill other fields here
            }
        });
    }
    
    // Show file name on selection
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = this.files[0]?.name || 'No file chosen';
            const label = this.nextElementSibling;
            const textSpan = label.querySelector('.text span');
            
            if (textSpan) {
                textSpan.textContent = fileName;
            }
        });
    });
    
    // Real-time validation
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error');
            const errorDiv = this.parentElement.querySelector('.error-message');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        });
    });
});
</script>
@endpush