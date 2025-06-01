<?php

namespace App\Http\Controllers\Admin;


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
        // Bạn có thể truyền thêm dữ liệu ban đầu tới view nếu cần
        // Ví dụ: danh sách các sản phẩm bán chạy nhất, các danh mục...
        return view('index'); // Chúng ta sẽ tạo view này ở bước sau
    }

    /**
     * Xử lý yêu cầu tìm kiếm sản phẩm (thường được gọi qua AJAX).
     * Tìm kiếm dựa trên tên sản phẩm, mã vạch (barcode), hoặc SKU.
     */
    public function searchProducts(Request $request)
    {
        $searchTerm = $request->input('term'); // Từ khóa tìm kiếm từ client
        $products = Product::where(function ($query) use ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('barcode', $searchTerm)
                  ->orWhere('sku', $searchTerm);
        })
        ->where('stock_quantity', '>', 0) // Chỉ lấy sản phẩm còn hàng
        ->take(15) // Giới hạn số lượng kết quả trả về để tối ưu hiệu năng
        ->get(['id', 'name', 'barcode', 'selling_price', 'stock_quantity', 'image_url']); // Lấy các trường cần thiết
        return response()->json($products);

        
    }

    /**
     * Xử lý việc gửi và lưu thông tin đơn hàng (thường được gọi qua AJAX).
     */
    public function submitSale(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'cart_items' => 'required|array|min:1',
            'cart_items.*.product_id' => 'required|exists:products,id', // Kiểm tra product_id có tồn tại trong bảng products
            'cart_items.*.quantity' => 'required|integer|min:1',      // Số lượng phải là số nguyên, ít nhất là 1
            'cart_items.*.price' => 'required|numeric|min:0',         // Giá bán (có thể đã được sửa) phải là số, không âm
            'payment_method' => 'sometimes|string|max:50',            // Phương thức thanh toán (tùy chọn)
            // 'customer_id' => 'nullable|exists:customers,id',       // Nếu có quản lý khách hàng
            // 'notes' => 'nullable|string'                             // Ghi chú cho đơn hàng
        ]);

        $cartItems = $validatedData['cart_items'];
        $paymentMethod = $request->input('payment_method', 'Tiền mặt'); // Mặc định là Tiền mặt
        $grandTotal = 0;

        // Tính tổng tiền và kiểm tra tồn kho một lần nữa trước khi vào transaction
        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock_quantity < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "' . ($product->name ?? 'ID: ' . $item['product_id']) . '" không đủ số lượng tồn kho hoặc không tồn tại!'
                ], 400); // Bad Request
            }
            $grandTotal += $item['quantity'] * $item['price'];
        }

        // Bắt đầu một DB transaction để đảm bảo tất cả các thao tác CSDL thành công hoặc không gì cả
        DB::beginTransaction();
        try {
            // 1. Tạo bản ghi mới cho Hóa đơn (Sale)
            $sale = Sale::create([
                //'user_id' => Auth::id(), // ID của nhân viên đang thực hiện giao dịch
                'total_amount' => $grandTotal,
                'payment_method' => $paymentMethod,
                // Thêm các trường khác như customer_id, notes nếu có
            ]);

            // 2. Thêm các Chi tiết Hóa đơn (Sale Items) và cập nhật số lượng Tồn kho
            foreach ($cartItems as $itemData) {
                $product = Product::find($itemData['product_id']); // Lấy lại thông tin sản phẩm

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'price_at_sale' => $itemData['price'], // Giá bán tại thời điểm giao dịch (có thể đã được nhân viên sửa)
                    'cost_at_sale' => $product->purchase_price, // Giá nhập của sản phẩm (để tính lợi nhuận)
                ]);

                // Giảm số lượng tồn kho của sản phẩm
                // $product->stock_quantity -= $itemData['quantity'];
                // $product->save();
                // Hoặc dùng phương thức decrement của Laravel cho an toàn hơn về race condition
                $product->decrement('stock_quantity', $itemData['quantity']);
            }

            DB::commit(); // Lưu tất cả thay đổi vào CSDL
            return response()->json([
                'success' => true,
                'message' => 'Thanh toán và lưu đơn hàng thành công!',
                'sale_id' => $sale->id // Trả về ID của hóa đơn vừa tạo, có thể dùng để in hóa đơn
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác tất cả thay đổi nếu có lỗi xảy ra
            Log::error('Lỗi khi tạo đơn hàng POS: ' . $e->getMessage()); // Ghi log lỗi để kiểm tra
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra trong quá trình xử lý đơn hàng. Vui lòng thử lại.'
            ], 500); // Internal Server Error
        }
    }
}