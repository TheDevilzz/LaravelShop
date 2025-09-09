@extends('adminlayout')
@section('product')
    active-nav-link
@endsection
@section('title')
    Product Upload
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6, #1d4ed8);
            --bg-gradient: linear-gradient(180deg, #f8fafc, #ffffff);
            --shadow-elegant: 0 4px 20px -4px rgba(59, 130, 246, 0.15);
            --shadow-soft: 0 2px 8px -2px rgba(0, 0, 0, 0.1);
            }

        body {
            background: var(--bg-gradient);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow: auto;
        }

        .gradient-primary {
            background: var(--primary-gradient);
        }

        .shadow-elegant {
            box-shadow: var(--shadow-elegant);
        }

        .shadow-soft {
            box-shadow: var(--shadow-soft);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-elegant);
        }

        .image-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .image-upload-area:hover,
        .image-upload-area.dragover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .image-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-soft);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transform: translateY(-1px);
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-icon {
            width: 4rem;
            height: 4rem;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .loading-spinner {
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection
@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="text-center mb-5 animate-fade-in">
            <div class="hero-icon">
                <i class="bi bi-box-seam text-white fs-3"></i>
            </div>
            <h1 class="display-4 fw-bold text-dark mb-3">Upload Product</h1>
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
                       <form method="POST" action="{{ route('addProduct') }}" enctype="multipart/form-data" id="productForm">
    @csrf
    <div class="mb-4">
        <label for="productName" class="form-label fw-semibold">
            <i class="bi bi-tag me-2"></i>Product Name *
        </label>
        <input type="text" class="form-control form-control-lg" id="productName" 
               name="productName" placeholder="Enter product name" required>
    </div>

    <!-- Product Description -->
    <div class="mb-4">
        <label for="productDescription" class="form-label fw-semibold">
            <i class="bi bi-file-text me-2"></i>Product Description *
        </label>
        <textarea class="form-control" id="productDescription" name="productDescription" rows="4" 
                  placeholder="Describe your product" required></textarea>
    </div>

    <!-- Price and Quantity Row -->
    <div class="row mb-4">
        <div class="col-md-6">
            <label for="productPrice" class="form-label fw-semibold">Price *</label>
            <div class="input-group">
                <input type="number" class="form-control form-control-lg" 
                       id="productPrice" name="productPrice" placeholder="0.00" step="0.25" min="0" required>
            </div>
        </div>
        <div class="col-md-6">
            <label for="productQuantity" class="form-label fw-semibold">
                <i class="bi bi-hash me-2"></i>Quantity *
            </label>
            <input type="number" class="form-control form-control-lg" 
                   id="productQuantity" name="productQuantity" placeholder="0" min="0" required>
        </div>
    </div>

    <!-- Product Image -->
    <input type="file" id="productImage" name="productImage" accept="image/*">
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
            <i class="bi bi-upload me-2"></i>Upload Product
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
@section('js')
        // Form elements
        const form = document.getElementById('productForm');
        const submitBtn = document.getElementById('submitBtn');
        const imageUploadArea = document.getElementById('imageUploadArea');
        const imageInput = document.getElementById('productImage');
        const uploadPrompt = document.getElementById('uploadPrompt');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeImageBtn = document.getElementById('removeImage');

        // Modals and Toasts
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));

        // Image upload functionality
        imageUploadArea.addEventListener('click', () => imageInput.click());
        
        imageUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadArea.classList.add('dragover');
        });

        imageUploadArea.addEventListener('dragleave', () => {
            imageUploadArea.classList.remove('dragover');
        });

        imageUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleImageFile(files[0]);
            }
        });

        imageInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleImageFile(e.target.files[0]);
            }
        });

        removeImageBtn.addEventListener('click', () => {
            imageInput.value = '';
            uploadPrompt.classList.remove('d-none');
            imagePreview.classList.add('d-none');
        });

        function handleImageFile(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    uploadPrompt.classList.add('d-none');
                    imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }
        // Form validation styling
        form.addEventListener('input', (e) => {
            if (e.target.checkValidity()) {
                e.target.classList.remove('is-invalid');
                e.target.classList.add('is-valid');
            } else {
                e.target.classList.remove('is-valid');
                e.target.classList.add('is-invalid');
            }
        });
@endsection