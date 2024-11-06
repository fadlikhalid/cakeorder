<!DOCTYPE html>
<html>
<head>
    <title>Order #{{ $order->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            padding: 20px;
            line-height: 1.6;
            color: #1a1a1a;
            background: #fff;
        }

        .print-content {
            max-width: 700px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .header h2 {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 5px 0;
            color: #000;
        }

        .order-number {
            font-size: 15px;
            color: #666;
            margin: 0;
        }

        .order-date {
            font-size: 14px;
            color: #888;
            margin: 5px 0 0 0;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .detail-row {
            display: flex;
            padding: 12px 16px;
            background: #f8f9fa;
            border-radius: 8px;
            align-items: center;
        }

        .detail-label {
            font-weight: 500;
            width: 140px;
            color: #4a5568;
            font-size: 14px;
        }

        .detail-value {
            flex: 1;
            color: #1a202c;
            font-size: 14px;
        }

        .special-instructions {
            margin-top: 25px;
            padding: 20px;
            background: #fff8dc;
            border-radius: 8px;
            border-left: 4px solid #ffd700;
        }

        .special-instructions-title {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .special-instructions-content {
            color: #4a5568;
            font-size: 14px;
            white-space: pre-line;
        }

        .footer {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #f0f0f0;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .business-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: left;
        }

        .info-title {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .business-hours p,
        .contact-info p {
            margin: 5px 0;
            font-size: 13px;
            color: #4a5568;
        }

        @media print {
            body {
                padding: 0;
                background: none;
            }

            .print-content {
                box-shadow: none;
                padding: 20px;
            }

            .no-print {
                display: none;
            }

            .detail-row {
                break-inside: avoid;
            }

            .special-instructions {
                break-inside: avoid;
            }

            .business-info {
                break-inside: avoid;
                background: none;
                border: 1px solid #eee;
            }
        }
    </style>
</head>
<body>
    <div class="print-content">
        <div class="header">
            <h2>ORDER DETAILS</h2>
            <p class="order-number">Order #{{ $order->id }}</p>
            <p class="order-date">{{ now()->format('d M Y, h:i A') }}</p>
        </div>

        <div class="details-grid">
            <div class="detail-row">
                <div class="detail-label">Customer Name</div>
                <div class="detail-value">{{ $order->buyer_name }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Phone</div>
                <div class="detail-value">{{ $order->buyer_phone }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Address</div>
                <div class="detail-value">{{ $order->buyer_address }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Cake Type</div>
                <div class="detail-value">{{ $order->cake_type }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Size</div>
                <div class="detail-value">{{ $order->cake_size }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Price</div>
                <div class="detail-value">RM {{ number_format($order->price, 2) }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Delivery Date</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($order->delivery_pickup_date)->format('d M Y') }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Delivery Time</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($order->delivery_pickup_time)->format('h:i A') }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Cake Message</div>
                <div class="detail-value">{{ $order->special_instructions ?: 'N/A' }}</div>
            </div>
        </div>

        @if($order->remarks || true)
        <div class="special-instructions">
            <div class="special-instructions-title">Additional Remarks</div>
            <div class="special-instructions-content">{{ $order->remarks ?: 'N/A' }}</div>
        </div>
        @endif

        <div class="footer">
            <p>Thank you for your order!</p>
            <div class="business-info">
                <div class="business-hours">
                    <p class="info-title">Business Hours</p>
                    <p>Tuesday - Sunday</p>
                    <p>9:00 AM - 6:00 PM</p>
                    <p>Closed on Mondays</p>
                </div>
                <div class="contact-info">
                    <p class="info-title">Contact Us</p>
                    <p>Phone: {{ config('business.phone', '012-345 6789') }}</p>
                    <p>Email: {{ config('business.email', 'orders@cakeshop.com') }}</p>
                    <p>Address: {{ config('business.address', '123 Cake Street, 12345 City') }}</p>
                </div>
            </div>
        </div>

        <div class="no-print" style="margin-top: 20px; text-align: center;">
            <a href="{{ route('orders.index') }}" 
               style="text-decoration: none; color: #666; font-size: 14px;">
                Back to Orders
            </a>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.location.href = '{{ route('orders.index') }}';
            };
        };
    </script>
</body>
</html> 