<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get today's and tomorrow's dates
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');

        // Get today's orders grouped by status
        $orders = [
            'Preparing' => Order::whereDate('delivery_pickup_date', $today)
                               ->where('status', 'Preparing')
                               ->orderBy('delivery_pickup_time')
                               ->orderBy('created_at')
                               ->get(),
            'Prepared' => Order::whereDate('delivery_pickup_date', $today)
                              ->where('status', 'Prepared')
                              ->orderBy('delivery_pickup_time')
                              ->orderBy('created_at')
                              ->get(),
            'Delivered' => Order::whereDate('delivery_pickup_date', $today)
                               ->where('status', 'Delivered')
                               ->orderBy('delivery_pickup_time')
                               ->orderBy('created_at')
                               ->get(),
            'Tomorrow' => Order::whereDate('delivery_pickup_date', $tomorrow)
                              ->orderBy('delivery_pickup_time')
                              ->orderBy('created_at')
                              ->get()
        ];

        // Debug log
        \Log::info('Orders summary:', [
            'today_count' => $orders['Preparing']->count() + $orders['Prepared']->count() + $orders['Delivered']->count(),
            'tomorrow_count' => $orders['Tomorrow']->count(),
            'preparing' => $orders['Preparing']->count(),
            'prepared' => $orders['Prepared']->count(),
            'delivered' => $orders['Delivered']->count()
        ]);

        return view('dashboard.index', compact('orders'));
    }
} 