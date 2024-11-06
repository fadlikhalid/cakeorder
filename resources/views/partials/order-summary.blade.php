@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Today's Orders Section -->
    <div class="section-container mb-4">
        <div class="section-header">
            <h2>Today's Orders</h2>
            <div class="date-badge">{{ now()->format('d M Y') }}</div>
        </div>

        <!-- Preparing Orders -->
        <div class="order-section {{ isset($orders['Preparing']) && $orders['Preparing']->count() > 0 ? 'preparing' : '' }}">
            <div class="section-title">
                <i class="fas fa-hourglass-half me-2"></i>
                Preparing
                <span class="count-badge">{{ isset($orders['Preparing']) ? $orders['Preparing']->count() : 0 }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($orders['Preparing'] ?? collect() as $order)
                    <div class="order-card">
                        <div class="order-header" onclick="toggleDetails(this)">
                            <div class="order-summary">
                                <i class="fas fa-chevron-right toggle-icon"></i>
                                <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                <span class="order-title">{{ $order->cake_type }}</span>
                                <span class="order-subtitle">{{ $order->buyer_name }}</span>
                            </div>
                            <div class="action-buttons" onclick="event.stopPropagation()">
                                <form action="{{ secure_url('orders/'.$order->id.'/status') }}" method="POST" class="ajax-form d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Prepared">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Mark as Prepared
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="order-details collapse">
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Pickup Time</div>
                                    <div class="detail-value">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Size</div>
                                    <div class="detail-value">{{ $order->cake_size ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value">
                                        <a href="tel:{{ $order->buyer_phone }}" class="phone-link">
                                            {{ $order->buyer_phone ?? 'N/A' }}
                                        </a>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Price</div>
                                    <div class="detail-value">RM {{ number_format($order->price ?? 0, 2) }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Customer Name</div>
                                    <div class="detail-value">{{ $order->buyer_name ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Address</div>
                                    <div class="detail-value">{{ $order->buyer_address ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Special Instructions</div>
                                    <div class="detail-value instructions">{{ $order->special_instructions ?: 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Additional Remarks</div>
                                    <div class="detail-value remarks">{{ $order->remarks ?: 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No orders preparing</div>
                @endforelse
            </div>
        </div>

        <!-- Prepared Orders -->
        <div class="order-section {{ isset($orders['Prepared']) && $orders['Prepared']->count() > 0 ? 'prepared' : '' }}">
            <div class="section-title">
                <i class="fas fa-check-circle me-2"></i>
                Prepared
                <span class="count-badge">{{ isset($orders['Prepared']) ? $orders['Prepared']->count() : 0 }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($orders['Prepared'] ?? collect() as $order)
                    <div class="order-card">
                        <div class="order-header" onclick="toggleDetails(this)">
                            <div class="order-summary">
                                <i class="fas fa-chevron-right toggle-icon"></i>
                                <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                <span class="order-title">{{ $order->cake_type }}</span>
                                <span class="order-subtitle">{{ $order->buyer_name }}</span>
                            </div>
                            <div class="action-buttons" onclick="event.stopPropagation()">
                                <form action="{{ secure_url('orders/'.$order->id.'/status') }}" method="POST" class="ajax-form d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Delivered">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Mark as Delivered
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="order-details collapse">
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Pickup Time</div>
                                    <div class="detail-value">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Size</div>
                                    <div class="detail-value">{{ $order->cake_size ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value">
                                        <a href="tel:{{ $order->buyer_phone }}" class="phone-link">
                                            {{ $order->buyer_phone ?? 'N/A' }}
                                        </a>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Price</div>
                                    <div class="detail-value">RM {{ number_format($order->price ?? 0, 2) }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Customer Name</div>
                                    <div class="detail-value">{{ $order->buyer_name ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Address</div>
                                    <div class="detail-value">{{ $order->buyer_address ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Special Instructions</div>
                                    <div class="detail-value instructions">{{ $order->special_instructions ?: 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Additional Remarks</div>
                                    <div class="detail-value remarks">{{ $order->remarks ?: 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No prepared orders</div>
                @endforelse
            </div>
        </div>

        <!-- Delivered Orders -->
        <div class="order-section {{ isset($orders['Delivered']) && $orders['Delivered']->count() > 0 ? 'delivered' : '' }}">
            <div class="section-title">
                <i class="fas fa-truck me-2"></i>
                Delivered
                <span class="count-badge">{{ isset($orders['Delivered']) ? $orders['Delivered']->count() : 0 }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($orders['Delivered'] ?? collect() as $order)
                    <div class="order-card">
                        <div class="order-header" onclick="toggleDetails(this)">
                            <div class="order-summary">
                                <i class="fas fa-chevron-right toggle-icon"></i>
                                <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                <span class="order-title">{{ $order->cake_type }}</span>
                                <span class="order-subtitle">{{ $order->buyer_name }}</span>
                            </div>
                        </div>
                        <div class="order-details collapse">
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Pickup Time</div>
                                    <div class="detail-value">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Size</div>
                                    <div class="detail-value">{{ $order->cake_size ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value">
                                        <a href="tel:{{ $order->buyer_phone }}" class="phone-link">
                                            {{ $order->buyer_phone ?? 'N/A' }}
                                        </a>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Price</div>
                                    <div class="detail-value">RM {{ number_format($order->price ?? 0, 2) }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Customer Name</div>
                                    <div class="detail-value">{{ $order->buyer_name ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Address</div>
                                    <div class="detail-value">{{ $order->buyer_address ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Special Instructions</div>
                                    <div class="detail-value instructions">{{ $order->special_instructions ?: 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Additional Remarks</div>
                                    <div class="detail-value remarks">{{ $order->remarks ?: 'N/A' }}</div>
                                </div>
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
        <div class="section-header tomorrow">
            <h2>Tomorrow's Orders</h2>
            <div class="date-badge">{{ now()->addDay()->format('d M Y') }}</div>
        </div>

        <div class="order-section">
            <div class="section-title">
                <i class="fas fa-calendar-day me-2"></i>
                Upcoming Orders
                <span class="count-badge">{{ $tomorrowOrders->flatten()->count() }}</span>
            </div>
            
            <div class="orders-list">
                @forelse ($tomorrowOrders->flatten() as $order)
                    <div class="order-card">
                        <div class="order-header" onclick="toggleDetails(this)">
                            <div class="order-summary">
                                <i class="fas fa-chevron-right toggle-icon"></i>
                                <span class="order-time">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</span>
                                <span class="order-title">{{ $order->cake_type }}</span>
                                <span class="order-subtitle">{{ $order->buyer_name }}</span>
                            </div>
                        </div>
                        <div class="order-details collapse">
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Size</div>
                                    <div class="detail-value">{{ $order->cake_size }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value">{{ $order->buyer_phone }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Price</div>
                                    <div class="detail-value">RM {{ number_format($order->price, 2) }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Address</div>
                                    <div class="detail-value">{{ $order->buyer_address }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Special Instructions</div>
                                    <div class="detail-value instructions">{{ $order->special_instructions ?: 'N/A' }}</div>
                                </div>
                                <div class="detail-item full-width">
                                    <div class="detail-label">Additional Remarks</div>
                                    <div class="detail-value remarks">{{ $order->remarks ?: 'N/A' }}</div>
                                </div>
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

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.section-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow: hidden;
}

.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-header h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.date-badge {
    background: rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
}

.order-section {
    padding: 20px;
    border-bottom: 1px solid #eef2f7;
}

.section-title {
    font-size: 1.1rem;
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.count-badge {
    background: #e2e8f0;
    color: #4a5568;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    margin-left: 8px;
}

.order-card {
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: all 0.2s ease;
}

.order-card:hover {
    background: #f1f5f9;
}

.order-header {
    padding: 15px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-summary {
    display: flex;
    align-items: center;
    gap: 12px;
}

.order-time {
    color: #64748b;
    font-size: 0.9rem;
}

.order-title {
    font-weight: 500;
    color: #1e293b;
}

.order-subtitle {
    color: #64748b;
    font-size: 0.9rem;
}

.toggle-icon {
    transition: transform 0.2s ease;
    color: #94a3b8;
}

.order-card.expanded .toggle-icon {
    transform: rotate(90deg);
}

.order-details {
    padding: 0 15px 15px;
    border-top: 1px solid #e2e8f0;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-label {
    font-size: 0.8rem;
    color: #64748b;
    margin-bottom: 4px;
}

.detail-value {
    color: #1e293b;
    font-size: 0.95rem;
}

.detail-value.instructions {
    background: #f1f5f9;
    padding: 8px;
    border-radius: 4px;
    font-size: 0.9rem;
}

.empty-state {
    text-align: center;
    padding: 20px;
    color: #64748b;
    font-style: italic;
}

.btn {
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.preparing {
    border-left: 4px solid #f59e0b;
}

.prepared {
    border-left: 4px solid #10b981;
}

.delivered {
    border-left: 4px solid #6366f1;
}

.btn-success {
    background-color: #10b981;
    border-color: #10b981;
    color: white;
}

.btn-success:hover {
    background-color: #059669;
    border-color: #059669;
}

.section-header.tomorrow {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.section-container + .section-container {
    margin-top: 2rem;
}

/* Updated and new mobile-friendly styles */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 10px;
    }

    .section-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .order-header {
        flex-direction: column;
        gap: 10px;
    }

    .order-summary {
        width: 100%;
        flex-wrap: wrap;
        gap: 8px;
    }

    .action-buttons {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .action-buttons form {
        width: 100%;
    }

    .action-buttons button {
        width: 100%;
        padding: 8px;
    }

    .details-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .detail-item {
        background: #f8fafc;
        padding: 10px;
        border-radius: 6px;
    }

    .order-card {
        margin-bottom: 15px;
    }

    .order-time {
        background: #e2e8f0;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
    }

    .order-title {
        font-size: 1.1rem;
        width: 100%;
    }

    .order-subtitle {
        width: 100%;
    }
}

/* Enhanced styles for all screen sizes */
.order-summary {
    flex-wrap: wrap;
    gap: 8px;
}

.phone-link {
    color: #3b82f6;
    text-decoration: none;
}

.phone-link:hover {
    text-decoration: underline;
}

.detail-item {
    transition: background-color 0.2s ease;
}

.detail-item:hover {
    background-color: #f1f5f9;
}

.detail-label {
    font-weight: 500;
    color: #4b5563;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

.detail-value {
    margin-top: 2px;
    line-height: 1.4;
}

.order-card {
    border: 1px solid #e5e7eb;
}

.order-details {
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Status-specific styles */
.preparing .order-time {
    color: #f59e0b;
    font-weight: 500;
}

.prepared .order-time {
    color: #10b981;
    font-weight: 500;
}

.delivered .order-time {
    color: #6366f1;
    font-weight: 500;
}

/* Enhanced button styles */
.btn {
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-width: 120px;
}

.btn i {
    font-size: 0.9em;
}

/* Custom toast styles */
.toastify {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    font-size: 14px;
    font-weight: 500;
    opacity: 0;
    animation: slideIn 0.2s ease forwards;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .toastify {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
    }
}

/* Enhanced toast animations */
.toast-animate {
    opacity: 0;
    animation: toastSlideIn 0.3s ease forwards, toastFadeOut 0.3s ease forwards;
    animation-delay: 0s, calc(var(--toastify-duration, 2000) - 300)ms;
}

@keyframes toastSlideIn {
    from {
        transform: translateX(100%) translateY(-50%);
        opacity: 0;
    }
    to {
        transform: translateX(0) translateY(0);
        opacity: 1;
    }
}

@keyframes toastFadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* Dark mode adjustments */
@media (prefers-color-scheme: dark) {
    .toast-animate {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    }
}
</style>

<script>
function toggleDetails(element) {
    const card = element.closest('.order-card');
    const details = card.querySelector('.order-details');
    card.classList.toggle('expanded');
    details.classList.toggle('collapse');
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.ajax-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const formData = new FormData(this);
                const status = formData.get('status');
                const urlEncodedData = new URLSearchParams(formData).toString();
                
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: urlEncodedData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                // Success toast with improved styling
                Toastify({
                    text: `✓ Order marked as ${status}`,
                    duration: 2500,  // Slightly longer duration
                    gravity: "top",
                    position: "right",
                    style: {
                        background: status === 'delivered' ? "#059669" : "#4f46e5", // Emerald for delivered, Indigo for prepared
                        borderRadius: "8px",
                        padding: "12px 24px",
                        color: "white",
                        boxShadow: "0 4px 6px -1px rgba(0, 0, 0, 0.1)",
                        fontSize: "14px",
                        fontWeight: "500",
                    }
                }).showToast();

                // Reload after success
                setTimeout(() => {
                    window.location.reload();
                }, 2000);

            } catch (error) {
                console.error('Error:', error);
                
                // Error toast
                Toastify({
                    text: "⚠️ Failed to update status",
                    duration: 3000,  // Longer duration for error messages
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "#DC2626", // Bright red for errors
                        borderRadius: "8px",
                        padding: "12px 24px",
                        color: "white",
                        boxShadow: "0 4px 6px -1px rgba(0, 0, 0, 0.1)",
                        fontSize: "14px",
                        fontWeight: "500",
                    }
                }).showToast();
            }
        });
    });
});
</script>

@endsection
