@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Order Status</h1>

        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="p-3">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="status" class="form-label">Order Status</label>
                <select class="form-control" name="status" required>
                    <option value="Preparing" {{ $order->status == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="Prepared" {{ $order->status == 'Prepared' ? 'selected' : '' }}>Prepared</option>
                    <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="special_instructions">Special Instructions</label>
                <textarea name="special_instructions" id="special_instructions" 
                          class="form-control" rows="3">{{ $order->special_instructions }}</textarea>
            </div>

            {{-- Order Details (Read-only) --}}
            <div class="card mb-3">
                <div class="card-header">
                    Order Details
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Buyer Name:</strong> {{ $order->buyer_name }}</p>
                            <p><strong>Phone:</strong> {{ $order->buyer_phone }}</p>
                            <p><strong>Address:</strong> {{ $order->buyer_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Cake Type:</strong> {{ $order->cake_type }}</p>
                            <p><strong>Size:</strong> {{ $order->cake_size }}</p>
                            <p><strong>Price:</strong> RM{{ number_format($order->price, 2) }}</p>
                            <p><strong>Delivery/Pickup:</strong> 
                                {{ \Carbon\Carbon::parse($order->delivery_pickup_date)->format('d/m/Y') }}
                                {{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Status</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <style>
        .form-group {
            margin-bottom: 1rem;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .gap-2 {
            gap: 0.5rem;
        }
    </style>
@endsection