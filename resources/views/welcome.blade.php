@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1 class="display-4">Welcome to the Cake Order Management System!</h1>
    <p class="lead">Manage your cake orders efficiently.</p>
    <a class="btn btn-primary btn-lg" href="{{ route('cakes.index') }}" role="button">Get Started</a>
</div>
@endsection

