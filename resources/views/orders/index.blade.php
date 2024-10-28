@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Orders</h1>

        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Create New Order</a>

        @if ($orders->isEmpty())
            <div class="alert alert-info">
                There are no orders yet. Click "Create New Order" to start adding orders.
            </div>
        @else
            <table class="table table-striped table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Total Items</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->details->count() }}</td>
                            <td>
                                <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="btn btn-info">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
