@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order Summary</h1>

        <div class="row">
            <div class="col-md-6 mb-4">
                <h2>Today</h2>
                @include('partials.order-summary', ['orders' => [
                    'Ordered' => $orderedToday, 
                    'Paid' => $paidToday, 
                    'Delivering' => $deliveringToday, 
                    'Delivered' => $deliveredToday
                ]])
            </div>
            <div class="col-md-6 mb-4">
                <h2>Tomorrow</h2>
                @include('partials.order-summary', ['orders' => [
                    'Ordered' => $orderedTomorrow, 
                    'Paid' => $paidTomorrow, 
                    'Delivering' => $deliveringTomorrow, 
                    'Delivered' => $deliveredTomorrow
                ]])
            </div>
        </div>
    </div>
@endsection