<!-- resources/views/cakes/index.blade.php -->
@extends('layouts.app')

@section('title', 'Cakes Management')

@section('content')
<div class="dashboard-container">
    <div class="section-container">
        <div class="section-header">
            <h2>Cakes List</h2>
            <button type="button" class="btn btn-primary py-2" data-bs-toggle="modal" data-bs-target="#addCakeModal">
                <i class="fas fa-plus"></i><span class="ms-2">Add Cake</span>
            </button>
        </div>

        <!-- Search Section -->
        <div class="filters-wrapper mb-4">
            <form action="{{ route('cakes.index') }}" method="GET" class="filters-form">
                <div class="filter-group">
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search cakes..." 
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('cakes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo me-2"></i>Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Cakes List -->
        <div class="orders-list">
            @forelse($cakes as $cake)
                <div class="order-card">
                    <!-- Cake Header -->
                    <div class="order-header">
                        <div class="order-summary">
                            <i class="fas fa-birthday-cake text-primary me-2"></i>
                            <span class="order-title">{{ $cake->type }}</span>
                        </div>
                        <div class="filter-actions">
                            <button class="btn btn-primary py-2" style="min-width: 135px;" onclick="addSize({{ $cake->id }}, '{{ $cake->type }}')">
                                <i class="fas fa-plus me-2"></i>New Size
                            </button>
                            <button class="btn btn-danger py-2" style="min-width: 135px;" onclick="deleteCake({{ $cake->id }}, '{{ $cake->type }}')">
                                <i class="fas fa-trash me-2"></i>Delete Cake
                            </button>
                        </div>
                    </div>

                    <!-- Cake Sizes -->
                    <div class="details-container">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Size</th>
                                    <th style="width: 60%">Price</th>
                                    <th style="width: 20%" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cake->sizes as $size)
                                    <tr>
                                        <td class="align-middle">
                                            <span class="fw-medium">{{ $size->size }}"</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary">RM {{ number_format($size->price, 2) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="action-buttons">
                                                <button class="btn btn-light" 
                                                        onclick="editSize({{ $size->id }}, {{ $size->size }}, {{ $size->price }})"
                                                        title="Edit Price">
                                                    <i class="fas fa-edit text-primary"></i>
                                                </button>
                                                <button class="btn btn-light" 
                                                        onclick="deleteSize({{ $size->id }}, {{ $size->size }})"
                                                        title="Delete Size">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            <em>No sizes available for this cake</em>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-birthday-cake mb-3 text-muted"></i>
                    <p>No cakes found</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Include modals -->
@include('cakes.partials.add-cake-modal')
@include('cakes.partials.add-size-modal')
@include('cakes.partials.edit-size-modal')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/cakes.css') }}">
@endpush

@push('scripts')
<script>
    // Add new cake
    document.getElementById('addCakeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch('/cakes', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addCakeModal'));
                modal.hide();
                location.reload();
            } else {
                throw new Error(data.message || 'Failed to add cake');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
    });

    // Add new size
    window.addSize = function(cakeId, cakeType) {
        document.getElementById('cakeId').value = cakeId;
        document.getElementById('cakeTypeText').textContent = cakeType;
        new bootstrap.Modal(document.getElementById('addSizeModal')).show();
    }

    document.getElementById('addSizeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const cakeId = document.getElementById('cakeId').value;
        
        fetch(`/cakes/${cakeId}/sizes`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addSizeModal'));
                modal.hide();
                location.reload();
            } else {
                throw new Error(data.message || 'Failed to add size');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
    });

    // Edit size/price
    window.editSize = function(sizeId, size, price) {
        document.getElementById('editSizeId').value = sizeId;
        document.getElementById('editSize').value = size + '"';
        document.getElementById('editPrice').value = price;
        new bootstrap.Modal(document.getElementById('editSizeModal')).show();
    }

    document.getElementById('editSizeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const sizeId = document.getElementById('editSizeId').value;
        const price = document.getElementById('editPrice').value;
        
        fetch(`/cake-sizes/${sizeId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ price: price })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editSizeModal'));
                modal.hide();
                
                Toastify({
                    text: "Price updated successfully",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#10B981",
                }).showToast();
                
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Failed to update price');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Toastify({
                text: error.message || 'An error occurred',
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#EF4444",
            }).showToast();
        });
    });

    // Delete size function
    window.deleteSize = function(sizeId, size) {
        if (confirm(`Are you sure you want to delete ${size}" size?`)) {
            fetch(`/cake-sizes/${sizeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Toastify({
                        text: "Size deleted successfully",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#10B981",
                    }).showToast();
                    
                    setTimeout(() => location.reload(), 1000);
                } else {
                    throw new Error(data.message || 'Failed to delete size');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toastify({
                    text: error.message || 'An error occurred',
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#EF4444",
                }).showToast();
            });
        }
    }

    // Delete cake function
    window.deleteCake = function(cakeId, cakeType) {
        if (confirm(`Are you sure you want to delete ${cakeType}?`)) {
            fetch(`/cakes/${cakeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Toastify({
                        text: "Cake deleted successfully",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#10B981",
                    }).showToast();
                    
                    setTimeout(() => location.reload(), 1000);
                } else {
                    throw new Error(data.message || 'Failed to delete cake');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toastify({
                    text: error.message || 'An error occurred',
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#EF4444",
                }).showToast();
            });
        }
    }
</script>
@endpush