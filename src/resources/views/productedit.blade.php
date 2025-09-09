@extends('adminlayout')
@section('product')
    active-nav-link
@endsection
@section('title')
    Product Edit
@endsection
@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="text-center mb-5 animate-fade-in">
            <div class="hero-icon">
                <i class="bi bi-box-seam text-white fs-3"></i>
            </div>
            <h1 class="display-4 fw-bold text-dark mb-3">UpDate Product</h1>
            <p class="lead text-muted">Add a new product to your catalog with ease</p>
        </div>

        <!-- Main Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-elegant animate-fade-in">
                    <div class="card-header bg-white text-center py-4">
                        <h3 class="card-title mb-1">Product Details</h3>
                        <p class="text-muted mb-0">Fill in the information below to add your product</p>
                    </div>
                    <div class="card-body p-4">
                       <form method="POST" action="{{ route('updateProduct',$product->id) }}" enctype="multipart/form-data" id="productForm">
    @csrf
    <div class="mb-4">
        <label for="productName" class="form-label fw-semibold">
            <i class="bi bi-tag me-2"></i>Product Name *
        </label>
        <input type="text" class="form-control form-control-lg" id="productName" 
               name="productName" placeholder="Enter product name" value="{{$product->ProductName}}" required>
    </div>

    <!-- Product Description -->
    <div class="mb-4">
        <label for="productDescription" class="form-label fw-semibold">
            <i class="bi bi-file-text me-2"></i>Product Description *
        </label>
        <textarea class="form-control" id="productDescription" name="productDescription" rows="4" 
                  placeholder="Describe your product" required>{{$product->ProductDescription}}</textarea>
    </div>

    <!-- Price and Quantity Row -->
    <div class="row mb-4">
        <div class="col-md-6">
            <label for="productPrice" class="form-label fw-semibold">Price *</label>
            <div class="input-group">
                <input type="number" class="form-control form-control-lg" 
                       id="productPrice" name="productPrice" placeholder="0.00" step="0.25" min="0" value="{{$product->ProductPrice}}" required>
            </div>
        </div>
        <div class="col-md-6">
            <label for="productQuantity" class="form-label fw-semibold">
                <i class="bi bi-hash me-2"></i>Quantity *
            </label>
            <input type="number" class="form-control form-control-lg" 
                   id="productQuantity" name="productQuantity" placeholder="0" min="0" value="{{$product->ProductQuantity}}" required>
        </div>
    </div>

    <!-- Product Image -->
    <input type="file" id="productImage" name="productImage" accept="image/*" value="{{$product->ProductImage}}">
    <div class="mb-4">
       <!-- <label class="form-label fw-semibold">
            <i class="bi bi-image me-2"></i>Product Image
        </label>
        <div class="image-upload-area" id="imageUploadArea">
            <div id="uploadPrompt">
                <i class="bi bi-cloud-upload fs-1 text-primary mb-3"></i>
                <h5 class="mb-2">Upload product image</h5>
                <p class="text-muted mb-3">Drag and drop or click to browse</p>
                <button type="button" class="btn btn-outline-primary">
                    <i class="bi bi-folder me-2"></i>Choose File
                </button>
            </div>
            <div id="imagePreview" class="d-none">
                <img id="previewImg" class="image-preview" alt="Product preview">
                <div class="mt-3">
                    <button type="button" class="btn btn-danger btn-sm" id="removeImage">
                        <i class="bi bi-trash me-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>-->
        
    </div>

    <!-- Submit Button -->
    <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="bi bi-upload me-2"></i>Update Product
            </button>
           
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="hero-icon mb-3">
                        <i class="bi bi-check-lg text-white fs-3"></i>
                    </div>
                    <h4 class="mb-3">Product Uploaded Successfully!</h4>
                    <p class="text-muted mb-4">Your product has been added to the catalog.</p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="errorToast" class="toast" role="alert">
            <div class="toast-header bg-danger text-white">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="errorMessage">
                Something went wrong. Please try again.
            </div>
        </div>
    </div>
@endsection