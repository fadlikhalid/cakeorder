<?php

namespace App\Http\Controllers;

use App\Models\CakeSize;
use App\Models\Cake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeSizeController extends Controller
{
    public function store(Request $request, Cake $cake)
    {
        \Log::info('CakeSize store method called', [
            'cake_id' => $cake->id,
            'request' => $request->all()
        ]);

        try {
            $validated = $request->validate([
                'size' => 'required|numeric|min:1',
                'price' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            $size = $cake->sizes()->create([
                'size' => $validated['size'],
                'price' => $validated['price']
            ]);

            DB::commit();

            \Log::info('Size created successfully', ['size' => $size->toArray()]);

            return response()->json([
                'success' => true,
                'message' => 'Size added successfully',
                'data' => $size
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to add size', [
                'cake_id' => $cake->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add size: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'price' => 'required|numeric|min:0',
            ]);

            $size = CakeSize::findOrFail($id);
            $size->price = $request->price;
            $size->save();

            return response()->json([
                'success' => true,
                'message' => 'Price updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update price: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($sizeId)
    {
        try {
            $size = CakeSize::findOrFail($sizeId);
            
            // Check if size is used in any orders
            $hasOrders = \App\Models\Order::where('size_id', $sizeId)->exists();
            
            if ($hasOrders) {
                return response()->json([
                    'success' => false,
                    'message' => 'This cake size cannot be deleted as it is associated with existing orders. You may edit the price instead.'
                ], 400);
            }

            DB::beginTransaction();
            $size->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Size deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to delete size', [
                'size_id' => $sizeId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete size: ' . $e->getMessage()
            ], 500);
        }
    }
} 