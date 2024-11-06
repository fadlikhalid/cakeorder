@extends('layouts.app')

@section('title', 'Create New Order')

@section('content')
<div class="dashboard-container">
    <div class="section-container">
        <div class="section-header mb-4">
            <h2>Create New Order</h2>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    
                    <!-- Customer Information -->
                    <div class="section-subheader mb-4">
                        <h4 class="text-primary"><i class="fas fa-user me-2"></i>Customer Information</h4>
                    </div>
                    
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" 
                                       name="buyer_name" 
                                       class="form-control @error('buyer_name') is-invalid @enderror" 
                                       value="{{ old('buyer_name') }}" 
                                       required>
                                @error('buyer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" 
                                       name="buyer_phone" 
                                       class="form-control @error('buyer_phone') is-invalid @enderror" 
                                       value="{{ old('buyer_phone') }}" 
                                       pattern="[0-9]*"
                                       inputmode="numeric"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                @error('buyer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <textarea name="buyer_address" 
                                          class="form-control @error('buyer_address') is-invalid @enderror" 
                                          rows="2">{{ old('buyer_address') }}</textarea>
                                @error('buyer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="section-subheader mb-4">
                        <h4 class="text-primary"><i class="fas fa-birthday-cake me-2"></i>Order Details</h4>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Cake Type</label>
                                <select name="cake_id" 
                                        class="form-select @error('cake_id') is-invalid @enderror" 
                                        id="cakeTypeSelect"
                                        required>
                                    <option value="">Select Cake Type</option>
                                    @foreach($cakes as $cake)
                                        <option value="{{ $cake->id }}">{{ $cake->type }}</option>
                                    @endforeach
                                </select>
                                @error('cake_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Cake Size</label>
                                <select name="size_id" 
                                        class="form-select @error('size_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Select Size</option>
                                </select>
                                @error('size_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Delivery Date</label>
                                <input type="date" 
                                       name="delivery_pickup_date" 
                                       class="form-control @error('delivery_pickup_date') is-invalid @enderror"
                                       value="{{ old('delivery_pickup_date') }}"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('delivery_pickup_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Delivery Time</label>
                                <select name="delivery_pickup_time" 
                                        class="form-select @error('delivery_pickup_time') is-invalid @enderror"
                                        required>
                                    <option value="">Select Time</option>
                                    @php
                                        $start = new DateTime('09:00');
                                        $end = new DateTime('18:00');
                                        $interval = new DateInterval('PT30M');
                                        $times = new DatePeriod($start, $interval, $end);
                                        
                                        foreach ($times as $time) {
                                            $timeValue = $time->format('H:i');
                                            $timeDisplay = $time->format('h:i A');
                                            $selected = old('delivery_pickup_time') == $timeValue ? 'selected' : '';
                                            echo "<option value=\"$timeValue\" $selected>$timeDisplay</option>";
                                        }
                                    @endphp
                                </select>
                                @error('delivery_pickup_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="section-subheader mb-4">
                        <h4 class="text-primary"><i class="fas fa-info-circle me-2"></i>Additional Information</h4>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Message on Cake</label>
                                <textarea name="special_instructions" 
                                          class="form-control @error('special_instructions') is-invalid @enderror" 
                                          rows="3">{{ old('special_instructions') }}</textarea>
                                @error('special_instructions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Additional Remarks</label>
                                <textarea name="remarks" 
                                          class="form-control @error('remarks') is-invalid @enderror" 
                                          rows="2">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('orders.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>Create Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Order Created Successfully</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                <p class="mb-4">Would you like to print the order details?</p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-light px-4" onclick="skipPrint()">
                        Skip
                    </button>
                    <button type="button" class="btn btn-primary px-4" onclick="printOrder()">
                        <i class="fas fa-print me-2"></i>Print Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    console.log('Page loaded');
    const indexUrl = '{{ route('orders.index') }}';
</script>
<script src="{{ asset('js/order-form.js') }}" 
        onerror="console.error('Failed to load order-form.js')" 
        onload="console.log('order-form.js loaded')"></script>

<!-- Initialize print modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.printModal = new bootstrap.Modal(document.getElementById('printModal'));
    });
</script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/order-form.css') }}">
@endsection