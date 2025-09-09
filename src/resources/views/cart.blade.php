@extends('layout')
@section('title') Cart @endsection
@section('css')
<style>
    body { background: #f6f8fb; }
    .card { border: 0; box-shadow: 0 10px 25px rgba(0,0,0,.05); }
    .qty-input { width: 72px; text-align: center; }
    .cart-img { width: 72px; height: 72px; object-fit: cover; border-radius: .5rem; }
    .empty-state { padding: 3rem 1rem; text-align: center; color: #6c757d; }
    .price { white-space: nowrap; }
    .badge-pill { border-radius: 50rem; }
</style>
@endsection
@section('content')
@section('content')
<main class="container my-5">
    <form method="POST" action="{{ route('checkout') }}">
    @csrf
    <div class="row g-4">
        <!-- Cart items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3 p-md-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Your Cart</h5>
                        <span class="text-secondary">
                            <span id="cartCount">{{ count($cart) }}</span> items
                        </span>
                    </div>

                    <div id="cartList">
                        @if (count($cart) <= 0)
                            <!-- Empty state -->
                            <div id="emptyState" class="empty-state">
                                <i class="bi bi-cart-x display-6 d-block mb-2"></i>
                                Your cart is empty.
                                <div class="mt-3">
                                    <a href="{{ url('/') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                                    </a>
                                </div>
                            </div>
                        @else
                            @foreach ($cart as $item)
                                <div class="p-3 p-md-4 border-bottom cart-item" data-price="{{ $item->product->ProductPrice }}">
                                    <div class="d-flex gap-3 align-items-center">
                                        <img class="cart-img"
                                             src="{{ asset('uploads/products/' . $item->product->ProductImage) }}"
                                             alt="{{ $item->product->ProductName }}">
                                        <div class="flex-grow-1">
                                            <div class="d-flex flex-wrap justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product->ProductName }}</h6>
                                                    <div class="small text-secondary">In Stock: {{ $item->product->ProductQuantity }}</div>
                                                </div>
                                                <div class="price fw-semibold">
                                                    ฿<span class="line-price">{{ number_format($item->product->ProductPrice * $item->CartQuantity, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
                                                <div class="input-group input-group-sm" style="width: 130px;">
                                                    <a class="btn btn-outline-secondary btn-sm qty-minus" href="{{Route('minuscart', $item->id)}}">
                                                        <i class="bi bi-dash"></i>
                                                    </a>
                                                    <input type="number" class="form-control qty-input"
                                                           value="{{ $item->CartQuantity }}" min="1" readonly>
                                                    <a class="btn btn-outline-secondary btn-sm qty-plus" href="{{Route('pluscart', $item->id)}}">
                                                        <i class="bi bi-plus"></i>
                                                    </a>
                                                </div>
                                                <a href="{{ Route('deleteCart', $item->id) }}"
                                                   class="btn btn-link text-danger p-0 ms-2 remove-item">
                                                    <i class="bi bi-trash me-1"></i> Remove
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body p-3 p-md-4">
                    <h5 class="mb-3">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Subtotal</span>
                        <strong>฿<span id="subtotal">
                            {{ number_format($cart->sum(fn($item) => $item->product->ProductPrice * $item->CartQuantity), 2) }}
                        </span></strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fs-5 mb-3">
                        <span>Total</span>
                        <span class="fw-bold">฿<span id="grandTotal">
                            {{ number_format($cart->sum(fn($item) => $item->product->ProductPrice * $item->CartQuantity), 2) }}
                        </span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-3 p-md-4">
                    <h5 class="mb-3">Shipping Address</h5>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="postcode" class="form-label">Postcode</label>
                        <input type="text" class="form-control" id="postcode" name="postcode" required>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                    <input type="hidden" name="TotalPrice" id="TotalPrice" value="{{ $cart->sum(fn($item) => $item->product->ProductPrice * $item->CartQuantity) }}">
                    @if ($cart->sum(fn($item) => $item->product->ProductQuantity) < $cart->sum(fn($item) => $item->CartQuantity))
                        <button type="submit" class="btn btn-primary w-100 mt-2 disabled">
                        <i class="bi bi-shield-check me-1"></i> Checkout
                    </button>
                    @else
                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-shield-check me-1"></i> Checkout
                    </button>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    </form>
</main>
@endsection