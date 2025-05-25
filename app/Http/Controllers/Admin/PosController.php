<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosController 
{
    public function index()
    {
        return view('vendor.backpack.ui.inc.pos.index');
    }

    public function searchProducts(Request $request)
    {
        $term = $request->input('term');
        return Product::where('name', 'LIKE', "%{$term}%")
                     ->orWhere('barcode', $term)
                     ->orWhere('sku', $term)
                     ->where('stock_quantity', '>', 0)
                     ->take(10)
                     ->get(['id', 'name', 'selling_price', 'stock_quantity']);
    }

    public function submitSale(Request $request)
    {
        $request->validate([
            'cart_items' => 'required|array|min:1',
            'cart_items.*.product_id' => 'required|exists:products,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card'
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->cart_items as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }
                $total += $item['price'] * $item['quantity'];
            }

            $sale = Sales::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_method' => $request->payment_method
            ]);

            foreach ($request->cart_items as $item) {
                $product = Product::find($item['product_id']);
                SaleItems::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price_at_sale' => $item['price']
                ]);
                
                $product->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();
            return response()->json(['success' => true, 'sale_id' => $sale->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}