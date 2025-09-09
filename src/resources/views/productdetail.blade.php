@extends('layout')

@section('title')
    Product Detail
@endsection

@section('content')
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ asset('uploads/products/' . $product->ProductImage) }}" alt="..." /></div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder">{{$product->ProductName}}</h1>
                        
                        <div class="fs-5 mb-5">
                            <span>฿{{$product->ProductPrice}}</span>
                        </div>
                        <p class="lead">In Stock: {{$product->ProductQuantity}}</p>
                        <p class="lead">{{$product->ProductDescription}}</p>
                        <div class="d-flex">
                           <form method="POST" action="{{ route('addCarts', $product->id) }}">
                                 @csrf
                                <input type="number" name="inputQuantity" value="1" min="1" class="form-control text-center me-3" style="max-width:3rem">
                                <button type="submit" class="btn btn-outline-dark">Add to cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection