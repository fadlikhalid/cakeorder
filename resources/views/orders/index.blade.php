@extends('layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="dashboard-container">
    <!-- Filters Section -->
    <div class="section-container">
        <div class="section-header">
            <h2>Orders List</h2>
        </div>

        <div class="order-section">
            <!-- Filters -->
            <div class="filters-wrapper mb-4">
                <form action="{{ route('orders.index') }}" method="GET" class="filters-form">
                    <div class="filter-group">
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="date" 
                                   name="date" 
                                   class="form-control"
                                   value="{{ request('date') }}">
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-filter"></i>
                            </span>
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="Preparing" {{ request('status') == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                                <option value="Prepared" {{ request('status') == 'Prepared' ? 'selected' : '' }}>Prepared</option>
                                <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Orders List -->
            <div class="orders-list">
                @forelse ($orders as $order)
                    <div class="order-card" id="order-{{ $order->id }}">
                        <div class="order-header" onclick="toggleDetails(this)">
                            <div class="clickable-area">
                                <div class="order-summary">
                                    <i class="fas fa-chevron-down"></i>
                                    <span class="order-time">
                                        {{ \Carbon\Carbon::parse($order->delivery_pickup_date)->format('d M Y') }}
                                        {{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}
                                    </span>
                                    <span class="order-title">{{ $order->cake_type }} ({{ $order->cake_size }})</span>
                                    <span class="order-subtitle">{{ $order->buyer_name }}</span>
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                <!-- Status Badge -->
                                <span class="badge status-{{ strtolower($order->status) }}" data-order-id="{{ $order->id }}" data-status="{{ $order->status }}">
                                    {{ $order->status }}
                                </span>

                                <!-- Print Button -->
                                <a href="{{ route('orders.print', $order->id) }}" 
                                   class="btn btn-light btn-sm" 
                                   target="_blank" 
                                   title="Print Order">
                                    <i class="fas fa-print"></i>
                                </a>

                                <!-- Edit Status Button -->
                                <button type="button" 
                                        class="btn btn-light btn-sm" 
                                        onclick="editStatus({{ $order->id }}, '{{ $order->status }}')">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete Button -->
                                <button type="button" 
                                        class="btn btn-light btn-sm text-danger" 
                                        onclick="deleteOrder({{ $order->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="order-details">
                            <div class="details-row">
                                <strong>Phone:</strong>
                                <span>{{ $order->buyer_phone }}</span>
                            </div>
                            
                            <div class="details-row">
                                <strong>Address:</strong>
                                <span>{{ $order->buyer_address }}</span>
                            </div>
                            
                            @if($order->special_instructions || true)
                            <div class="details-row">
                                <strong>Cake Message:</strong>
                                <span>{{ $order->special_instructions ?: 'N/A' }}</span>
                            </div>
                            @endif
                            
                            @if($order->remarks || true)
                            <div class="details-row">
                                <strong>Additional Remarks:</strong>
                                <span>{{ $order->remarks ?: 'N/A' }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No orders found</div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper mt-4">
                <div class="pagination-container">
                    <p class="showing-text">
                        Showing <span>{{ $orders->firstItem() }}</span> to <span>{{ $orders->lastItem() }}</span> 
                        of <span>{{ $orders->total() }}</span> results
                    </p>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="orderIdInput">
                <div class="status-options">
                    <label class="status-option">
                        <input type="radio" name="status" value="Preparing">
                        <span class="status-label preparing">Preparing</span>
                    </label>
                    <label class="status-option">
                        <input type="radio" name="status" value="Prepared">
                        <span class="status-label prepared">Prepared</span>
                    </label>
                    <label class="status-option">
                        <input type="radio" name="status" value="Delivered">
                        <span class="status-label delivered">Delivered</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateStatus()">Update Status</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteOrderId">
                <p>Are you sure you want to delete this order? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Order</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle details function
    window.toggleDetails = function(element) {
        const detailsSection = element.nextElementSibling;
        detailsSection.classList.toggle('show');
        
        const icon = element.querySelector('.fa-chevron-down, .fa-chevron-up');
        if (icon) {
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }
    }

    // Consolidate status update functions
    window.editStatus = function(orderId, currentStatus) {
        const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
        document.getElementById('orderIdInput').value = orderId;
        
        const currentRadio = document.querySelector(`input[name="status"][value="${currentStatus}"]`);
        if (currentRadio) {
            currentRadio.checked = true;
        }
        
        statusModal.show();
    }

    window.updateStatus = function() {
        const orderId = document.getElementById('orderIdInput').value;
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        
        if (!selectedStatus) {
            Toastify({
                text: "Please select a status",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#EF4444",
            }).showToast();
            return;
        }

        fetch(`/orders/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: selectedStatus.value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('statusModal'));
                modal.hide();
                
                Toastify({
                    text: "Status updated successfully",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#10B981",
                }).showToast();
                
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Failed to update status');
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

    // Delete functions
    window.deleteOrder = function(orderId) {
        document.getElementById('deleteOrderId').value = orderId;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    window.confirmDelete = function() {
        const orderId = document.getElementById('deleteOrderId').value;
        
        fetch(`/orders/${orderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                modal.hide();
                
                Toastify({
                    text: "Order deleted successfully",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#10B981",
                }).showToast();
                
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Failed to delete order');
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
</script>
@endpush