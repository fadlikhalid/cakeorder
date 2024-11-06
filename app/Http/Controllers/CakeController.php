<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\CakeSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CakeController extends Controller
{
    // Show the form for creating a new cake
    public function create()
    {
        return view('cakes.create');
    }

    // Store a newly created cake in storage
    public function store(Request $request)
    {
        \Log::info('Adding new cake', ['request' => $request->all()]);

        try {
            $validated = $request->validate([
                'type' => 'required|string|max:255',
                'size' => 'required|numeric|min:1',
                'price' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();
            
            $cake = Cake::create([
                'type' => $validated['type']
            ]);

            $cake->sizes()->create([
                'size' => $validated['size'],
                'price' => $validated['price']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cake added successfully',
                'data' => $cake->load('sizes')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to add cake', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add cake: ' . $e->getMessage()
            ], 500);
        }
    }

    // List all cakes
    public function index()
    {
        $cakes = Cake::with('sizes')
            ->when(request('search'), function($query, $search) {
                $query->where('type', 'like', "%{$search}%");
            })
            ->orderBy('type')
            ->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($cakes);
        }
        
        return view('cakes.index', compact('cakes'));
    }

    // Show the form for editing a cake
    public function edit($id)
    {
        $cake = Cake::findOrFail($id);
        return view('cakes.edit', compact('cake'));
    }

    // Update a specific cake
    public function update(Request $request, Cake $cake)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Update the cake
        $cake->update($validated);

        return redirect()->route('cakes.index')->with('success', 'Cake updated successfully.');
    }

    // Delete a specific cake
    public function destroy($id)
    {
        try {
            $cake = Cake::findOrFail($id);
            
            // Check if any sizes are used in orders
            $hasOrders = \App\Models\Order::whereIn('size_id', $cake->sizes->pluck('id'))->exists();
            
            if ($hasOrders) {
                return response()->json([
                    'success' => false,
                    'message' => 'This cake type cannot be deleted as it has sizes associated with existing orders.'
                ], 400);
            }

            DB::beginTransaction();
            // Delete associated sizes first
            $cake->sizes()->delete();
            // Then delete the cake
            $cake->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cake deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to delete cake', [
                'cake_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete cake: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addSize(Request $request, Cake $cake)
    {
        try {
            $validated = $request->validate([
                'size' => 'required|numeric|min:1',
                'price' => 'required|numeric|min:0'
            ]);

            $cake->sizes()->create([
                'size' => $validated['size'],
                'price' => $validated['price']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Size added successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add size: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSizes(Cake $cake)
    {
        return response()->json($cake->sizes);
    }
}