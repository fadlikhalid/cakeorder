@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Order Details</h3>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Order Date/Time:</div>
                        <div class="col-md-8">
                            {{ $order->delivery_pickup_date }} at {{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Buyer Name:</div>
                        <div class="col-md-8">{{ $order->buyer_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Phone:</div>
                        <div class="col-md-8">{{ $order->buyer_phone }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Cake Type:</div>
                        <div class="col-md-8">{{ $order->cake_type }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Message:</div>
                        <div class="col-md-8">{{ $order->message }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $order->status == 'Preparing' ? 'warning' : ($order->status == 'Prepared' ? 'info' : 'success') }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    @if($order->remarks)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Remarks:</div>
                        <div class="col-md-8">{{ $order->remarks }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 