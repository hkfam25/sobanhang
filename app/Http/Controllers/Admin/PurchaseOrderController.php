<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use App\Models\Supplier;
// use App\Models\ProductSupplier; // Nếu dùng để gợi ý
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController 
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier', 'user')->latest()->paginate(15);
        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        // Bạn có thể truyền thêm danh sách sản phẩm ban đầu nếu muốn
        // $products = Product::orderBy('name')->where('stock_quantity', '>', 0)->get(); // Ví dụ
        return view('purchase_orders.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity_ordered' => 'required|integer|min:1',
            'items.*.cost_price_at_order' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($validatedData['items'] as $item) {
                $totalAmount += $item['quantity_ordered'] * $item['cost_price_at_order'];
            }

            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $validatedData['supplier_id'],
                'user_id' => Auth::id(),
                'order_date' => $validatedData['order_date'],
                'expected_delivery_date' => $validatedData['expected_delivery_date'],
                'status' => 'ordered', // Hoặc 'ordered' nếu bạn gửi ngay
                'total_amount' => $totalAmount,
                'notes' => $validatedData['notes'],
            ]);

            foreach ($validatedData['items'] as $itemData) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $itemData['product_id'],
                    'quantity_ordered' => $itemData['quantity_ordered'],
                    'cost_price_at_order' => $itemData['cost_price_at_order'],
                ]);
            }

            DB::commit();
            return redirect()->route('purchase-orders.index')->with('success', 'Phiếu nhập hàng đã được tạo thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi tạo phiếu nhập hàng: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Đã có lỗi xảy ra khi tạo phiếu nhập hàng. Vui lòng thử lại. Chi tiết: ' . $e->getMessage());
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items.product', 'supplier', 'user'); // Eager load relationships
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    // Các hàm edit, update, destroy bạn có thể tự phát triển nếu cần
    // Ví dụ hàm cập nhật trạng thái khi nhận hàng (đơn giản)
    public function receive(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Logic nhận hàng:
        // 1. Validate input (ví dụ: số lượng thực nhận cho từng item)
        // 2. Cập nhật quantity_received trong purchase_order_items
        // 3. Cập nhật stock_quantity trong products
        // 4. Cập nhật status của purchase_order (ví dụ: 'partial_received' hoặc 'received')
        // Đây là một ví dụ rất cơ bản, bạn cần mở rộng
        if ($purchaseOrder->status === 'ordered' || $purchaseOrder->status === 'partial_received') {
            DB::beginTransaction();
            try {
                foreach($request->items as $itemId => $itemData) {
                    $poItem = PurchaseOrderItem::find($itemId);
                    if ($poItem && isset($itemData['quantity_received'])) {
                        $quantityReceived = (int)$itemData['quantity_received'];
                        if ($quantityReceived > 0 && $quantityReceived <= ($poItem->quantity_ordered - $poItem->quantity_received) ) {
                             // Cập nhật số lượng thực nhận cho item
                            $poItem->quantity_received += $quantityReceived;
                            $poItem->save();

                            // Cập nhật tồn kho sản phẩm
                            $product = Product::find($poItem->product_id);
                            if ($product) {
                                $product->increment('stock_quantity', $quantityReceived);
                            }
                        }
                    }
                }
                // Kiểm tra xem đã nhận đủ hàng chưa để cập nhật status PO
                $totalOrdered = $purchaseOrder->items()->sum('quantity_ordered');
                $totalReceived = $purchaseOrder->items()->sum('quantity_received');

                if ($totalReceived >= $totalOrdered) {
                    $purchaseOrder->status = 'received';
                } else if ($totalReceived > 0) {
                    $purchaseOrder->status = 'partial_received';
                }
                $purchaseOrder->save();

                DB::commit();
                return redirect()->route('purchase-orders.show', $purchaseOrder)->with('success', 'Đã cập nhật thông tin nhận hàng.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Lỗi khi nhận hàng: ' . $e->getMessage());
                return back()->with('error', 'Lỗi khi cập nhật nhận hàng: ' . $e->getMessage());
            }
        }
        return back()->with('error', 'Không thể nhận hàng cho phiếu ở trạng thái này.');
    }
}
