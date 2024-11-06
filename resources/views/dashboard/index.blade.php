@extends('layouts.app')

@section('title', 'Dashboard - Order Management')

@section('content')
<div class="dashboard-container">
    <!-- Today's Orders -->
    <div class="section-container">
        <div class="section-header">
            <h2>Today's Orders</h2>
            <div class="date-badge">{{ now()->format('d M Y') }}</div>
        </div>

        <div class="order-section">
            <!-- Preparing Orders -->
            <div class="section-title">
                <i class="fas fa-calendar-check"></i>
                Preparing
                <span class="count-badge">{{ $orders['Preparing']->count() }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($orders['Preparing'] as $order)
                    <div class="order-card" id="order-{{ $order->id }}">
                        <div class="order-header">
                            <div class="clickable-area" onclick="toggleDetails(this)">
                                <div class="order-summary">
                                    <i class="fas fa-chevron-down"></i>
                                    <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                    <span class="order-title">{{ $order->cake_type }} ({{ $order->cake_size }})</span>
                                    <span class="order-subtitle">{{ $order->buyer_name }}</span>
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                @if($order->status == 'Preparing')
                                    <button onclick="updateStatus({{ $order->id }}, 'Prepared')" 
                                            class="btn-status preparing">
                                        Mark as Prepared
                                    </button>
                                @elseif($order->status == 'Prepared')
                                    <button onclick="updateStatus({{ $order->id }}, 'Delivered')" 
                                            class="btn-status prepared">
                                        Mark as Delivered
                                    </button>
                                @else
                                    <span class="status-badge delivered">Delivered</span>
                                @endif
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
                            
                            <div class="details-row">
                                <strong>Cake Message:</strong>
                                <span>{{ $order->special_instructions ?: 'N/A' }}</span>
                            </div>
                            
                            <div class="details-row">
                                <strong>Additional Remarks:</strong>
                                <span>{{ $order->remarks ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No preparing orders</div>
                @endforelse
            </div>

            <!-- Prepared Orders -->
            <div class="section-title mt-4">
                <i class="fas fa-check"></i>
                Prepared
                <span class="count-badge">{{ $orders['Prepared']->count() }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($orders['Prepared'] as $order)
                    <div class="order-card" id="order-{{ $order->id }}">
                        <div class="order-header">
                            <div class="clickable-area" onclick="toggleDetails(this)">
                                <div class="order-summary">
                                    <i class="fas fa-chevron-down"></i>
                                    <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                    <span class="order-title">{{ $order->cake_type }} ({{ $order->cake_size }})</span>
                                    <span class="order-subtitle">{{ $order->buyer_name }}</span>
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                @if($order->status == 'Preparing')
                                    <button onclick="updateStatus({{ $order->id }}, 'Prepared')" 
                                            class="btn-status preparing">
                                        Mark as Prepared
                                    </button>
                                @elseif($order->status == 'Prepared')
                                    <button onclick="updateStatus({{ $order->id }}, 'Delivered')" 
                                            class="btn-status prepared">
                                        Mark as Delivered
                                    </button>
                                @else
                                    <span class="status-badge delivered">Delivered</span>
                                @endif
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
                            
                            <div class="details-row">
                                <strong>Cake Message:</strong>
                                <span>{{ $order->special_instructions ?: 'N/A' }}</span>
                            </div>
                            
                            <div class="details-row">
                                <strong>Additional Remarks:</strong>
                                <span>{{ $order->remarks ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No prepared orders</div>
                @endforelse
            </div>

            <!-- Delivered Orders -->
            <div class="section-title mt-4">
                <i class="fas fa-truck"></i>
                Delivered
                <span class="count-badge">{{ $orders['Delivered']->count() }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($orders['Delivered'] as $order)
                    <div class="order-card" id="order-{{ $order->id }}">
                        <div class="order-header">
                            <div class="clickable-area" onclick="toggleDetails(this)">
                                <div class="order-summary">
                                    <i class="fas fa-chevron-down"></i>
                                    <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                    <span class="order-title">{{ $order->cake_type }} ({{ $order->cake_size }})</span>
                                    <span class="order-subtitle">{{ $order->buyer_name }}</span>
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                @if($order->status == 'Preparing')
                                    <button onclick="updateStatus({{ $order->id }}, 'Prepared')" 
                                            class="btn-status preparing">
                                        Mark as Prepared
                                    </button>
                                @elseif($order->status == 'Prepared')
                                    <button onclick="updateStatus({{ $order->id }}, 'Delivered')" 
                                            class="btn-status prepared">
                                        Mark as Delivered
                                    </button>
                                @else
                                    <span class="status-badge delivered">Delivered</span>
                                @endif
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
                            
                            <div class="details-row">
                                <strong>Cake Message:</strong>
                                <span>{{ $order->special_instructions ?: 'N/A' }}</span>
                            </div>
                            
                            <div class="details-row">
                                <strong>Additional Remarks:</strong>
                                <span>{{ $order->remarks ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No delivered orders</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tomorrow's Orders Section -->
    <div class="section-container">
        <div class="section-header">
            <h2>Tomorrow's Orders</h2>
            <div class="date-badge">{{ now()->addDay()->format('d M Y') }}</div>
        </div>

        <div class="order-section">
            <div class="section-title">
                <i class="fas fa-calendar"></i>
                Upcoming Orders
                <span class="count-badge">{{ $orders['Tomorrow']->count() }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($orders['Tomorrow'] as $order)
                    <div class="order-card" id="order-{{ $order->id }}">
                        <div class="order-header">
                            <div class="clickable-area" onclick="toggleDetails(this)">
                                <div class="order-summary">
                                    <i class="fas fa-chevron-down"></i>
                                    <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                    <span class="order-title">{{ $order->cake_type }} ({{ $order->cake_size }})</span>
                                    <span class="order-subtitle">{{ $order->buyer_name }}</span>
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                @if($order->status == 'Preparing')
                                    <button onclick="updateStatus({{ $order->id }}, 'Prepared')" 
                                            class="btn-status preparing">
                                        Mark as Prepared
                                    </button>
                                @else
                                    <span class="status-badge delivered">Prepared</span>
                                @endif
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
                            
                            <div class="details-row">
                                <strong>Cake Message:</strong>
                                <span>{{ $order->special_instructions ?: 'N/A' }}</span>
                            </div>
                            
                            <div class="details-row">
                                <strong>Additional Remarks:</strong>
                                <span>{{ $order->remarks ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No orders for tomorrow</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle details function
    window.toggleDetails = function(element) {
        const orderCard = element.closest('.order-card');
        const chevron = orderCard.querySelector('.fas');
        const details = orderCard.querySelector('.order-details');
        
        if (details) {
            details.classList.toggle('show');
            chevron.classList.toggle('fa-chevron-down');
            chevron.classList.toggle('fa-chevron-up');
        }
    }

    // Update status function
    window.updateStatus = function(orderId, newStatus) {
        fetch(`/orders/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Toastify({
                    text: `Order marked as ${newStatus}`,
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: newStatus === 'Prepared' ? "#4f46e5" : "#10B981",
                    stopOnFocus: true
                }).showToast();

                // Reload after successful update
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Toastify({
                text: "Error updating order status",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#EF4444",
                stopOnFocus: true
            }).showToast();
        });
    }
</script>
@endpush

@section('styles')
<style>
    /* Base styles */
    .dashboard-container {
        padding: 16px;
        max-width: 100%;
    }

    /* Order card */
    .order-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 12px;
        overflow: hidden;
    }

    /* Header and clickable area */
    .order-header {
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Order summary */
    .order-summary {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
    }

    .order-time {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .order-title {
        color: #111827;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .order-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }

    /* Details section */
    .order-details {
        display: none;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .order-details.show {
        display: block;
    }

    .details-row {
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
    }

    .details-row:last-child {
        border-bottom: none;
    }

    .details-row strong {
        color: #6b7280;
        width: 160px;
        flex-shrink: 0;
        font-weight: 500;
    }

    /* Button styles with original gradients */
    .btn-status {
        padding: 8px 16px;
        border-radius: 20px;
        border: none;
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-status.preparing {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    }

    .btn-status.preparing:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
    }

    .btn-status.prepared {
        background: linear-gradient(135deg, #059669 0%, #10B981 100%);
    }

    .btn-status.prepared:hover {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

    /* Delivered badge with same green gradient */
    .status-badge.delivered {
        padding: 6px 12px;
        border-radius: 20px;
        background: linear-gradient(135deg, #059669 0%, #10B981 100%);
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Count badge */
    .count-badge {
        background: #e5e7eb;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.875rem;
        color: #4b5563;
    }

    /* Mobile responsiveness */
    @media (max-width: 640px) {
        .order-header {
            flex-direction: column;
            gap: 8px;
        }

        .order-summary {
            width: 100%;
        }

        .details-row {
            flex-direction: column;
        }

        .details-row strong {
            width: 100%;
            margin-bottom: 4px;
        }

        .btn-status, .status-badge.delivered {
            width: 100%;
            text-align: center;
        }
    }

    /* Icon */
    .fas {
        color: #9ca3af;
        transition: transform 0.2s ease;
    }

    .fa-chevron-up {
        transform: rotate(180deg);
    }
</style>
@endsection 

