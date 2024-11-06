@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Main Menu</h2>
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ route('cakes.index') }}">Manage Cakes</a></li>
        <li class="list-group-item"><a href="{{ route('orders.index') }}">Manage Orders</a></li>
        <li class="list-group-item"><a href="/">Home</a></li>
    </ul>
</div>
@endsection

