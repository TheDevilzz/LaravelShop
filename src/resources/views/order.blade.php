@extends('adminlayout')
@section('order')
    active-nav-link
@endsection
@section('title')
    Order
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-elegant animate-fade-in">
                <div class="card-header bg-white text-center py-4">
                    <h3 class="card-title mb-1">Order List</h3>
                    <p class="text-muted mb-0">View and manage your order</p>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">User</th>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
                <th scope="col">Address</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($order as $order)
                @php
                    $products = json_decode($order->ProductList);
                @endphp
            <tr>
                <td>{{ $order->username }}</td>
                <td>
                    @foreach($products as $p)
                        {{ $p->ProductName }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach($products as $p)
                        {{ $p->CartQuantity }} <br>
                    @endforeach
                </td>
                <td>{{ $order->TotalPrice }}</td>
                <td>{{ $order->Address }}</td>
                <td>{{ $order->status }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    
@endsection