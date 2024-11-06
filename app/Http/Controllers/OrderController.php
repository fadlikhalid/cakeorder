<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cake;
use App\Models\CakeSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Method to update the order details
    public function update(Request $request, Order $order)
    {
        try {
            $order->update([
                'status' => $request->status
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Order status has been updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Failed to update order status.');
        }
    }

    // Method to update the order status
    public function updateStatus(Order $order, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Preparing,Prepared,Delivered'
        ]);

        $order->update(['status' => $validated['status']]);
        return response()->json(['success' => true]);
    }

    public function home()
    {
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');
    
        // Get all orders for today
        $todayOrders = Order::whereDate('delivery_pickup_date', $today)
            ->orderBy('delivery_pickup_time')
            ->get();
    
        // Group them by status with proper case
        $orders = [
            'Preparing' => $todayOrders->filter(function ($order) {
                return $order->status === 'Preparing';
            }),
            'Prepared' => $todayOrders->filter(function ($order) {
                return $order->status === 'Prepared';
            }),
            'Delivered' => $todayOrders->filter(function ($order) {
                return $order->status === 'Delivered';
            })
        ];
    
        // Tomorrow's orders
        $tomorrowOrders = Order::whereDate('delivery_pickup_date', $tomorrow)
            ->orderBy('delivery_pickup_time')
            ->get();
    
        Log::info('Current orders:', [
            'preparing' => $orders['Preparing']->count(),
            'prepared' => $orders['Prepared']->count(),
            'delivered' => $orders['Delivered']->count()
        ]);
    
        \Log::info('Orders by status:', ['orders' => $orders]); // Add logging
    
        return view('partials.order-summary', compact('orders', 'tomorrowOrders'));
    }
    
    

    public function index()
    {
        $query = Order::query();

        // Apply date filter
        if (request('date')) {
            $query->whereDate('delivery_pickup_date', request('date'));
        }

        // Apply status filter
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Sort by latest orders first
        $orders = $query->latest('created_at')  // Sort by creation date first
                        ->orderBy('delivery_pickup_date', 'desc')
                        ->orderBy('delivery_pickup_time', 'desc')
                        ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function summary()
    {
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');

        // Get today's orders and group them by status
        $todayOrders = Order::whereDate('delivery_pickup_date', $today)
            ->orderBy('delivery_pickup_time')
            ->get();

        $orders = [
            'Preparing' => $todayOrders->filter(function ($order) {
                return $order->status === 'Preparing';
            }),
            'Prepared' => $todayOrders->filter(function ($order) {
                return $order->status === 'Prepared';
            }),
            'Delivered' => $todayOrders->filter(function ($order) {
                return $order->status === 'Delivered';
            }),
            // Add Tomorrow's orders to the same array
            'Tomorrow' => Order::whereDate('delivery_pickup_date', $tomorrow)
                ->orderBy('delivery_pickup_time')
                ->get()
        ];

        // Log for debugging
        \Log::info('Orders summary:', [
            'today_count' => $todayOrders->count(),
            'tomorrow_count' => $orders['Tomorrow']->count(),
            'preparing' => $orders['Preparing']->count(),
            'prepared' => $orders['Prepared']->count(),
            'delivered' => $orders['Delivered']->count()
        ]);

        return view('dashboard.index', compact('orders'));
    }

    public function create()
    {
        $cakes = Cake::with('sizes')->get();
        return view('orders.create', compact('cakes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:20',
            'buyer_address' => 'required|string',
            'cake_id' => 'required|exists:cakes,id',
            'size_id' => 'required|exists:cake_sizes,id',
            'delivery_pickup_date' => 'required|date|after_or_equal:today',
            'delivery_pickup_time' => 'required',
            'special_instructions' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        try {
            // Get the cake and size details
            $cake = Cake::findOrFail($validated['cake_id']);
            $cakeSize = CakeSize::findOrFail($validated['size_id']);

            // Create the order
            $order = Order::create([
                'buyer_name' => $validated['buyer_name'],
                'buyer_phone' => $validated['buyer_phone'],
                'buyer_address' => $validated['buyer_address'],
                'cake_id' => $validated['cake_id'],
                'cake_type' => $cake->type,
                'size_id' => $validated['size_id'],
                'cake_size' => $cakeSize->size . '"',
                'price' => $cakeSize->price,
                'delivery_pickup_date' => $validated['delivery_pickup_date'],
                'delivery_pickup_time' => $validated['delivery_pickup_time'],
                'special_instructions' => $validated['special_instructions'],
                'remarks' => $validated['remarks'],
                'status' => 'Preparing'
            ]);

            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $cakes = Cake::with('sizes')->get();
        return view('orders.edit', compact('order', 'cakes'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['success' => true]);
    }

    public function printOrder(Order $order)
    {
        return view('orders.print-preview', compact('order'));
    }

    // Add this new method to handle size fetching
    public function getCakeSizes(Cake $cake)
    {
        return response()->json($cake->sizes()->get());
    }
}