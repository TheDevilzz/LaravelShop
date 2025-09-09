@extends('adminlayout')
@section('product')
    active-nav-link
@endsection
@section('title')
    Product
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-elegant animate-fade-in">
            <div class="card-header bg-white text-center py-4">
                <h3 class="card-title mb-1">Product List</h3>
                <p class="text-muted mb-0">View and manage your product catalog</p>
            </div>
        </div>
    </div>
</div>

<a href="{{Route('productupload')}}" class="btn btn-primary">Add Product</a>

@if (count($products)<=0)
    <h1 class="text-center mt-5">No Product Found</h1>
@else
    <table class="table table-auto mt-2">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Product Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <th scope="row">{{$product->id}}</th>
                    <td>{{$product->ProductName}}</td>
                    <td>{{Str::limit($product->ProductDescription, 50)}}</td>
                    <td>{{$product->ProductPrice}}</td>
                    <td>{{$product->ProductQuantity}}</td>
                    <td>
                        <form action="{{ route('editProduct', $product->id) }}" method="GET" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Edit
                            </button>
                        </form>
                        <form action="{{ route('deleteProduct', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger deleteButton">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$products->links()}}
@endif

@endsection
