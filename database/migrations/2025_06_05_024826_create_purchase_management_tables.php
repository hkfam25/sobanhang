<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique()->nullable()->comment('Mã phiếu nhập hàng, có thể tự sinh');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade')->comment('Nhà cung cấp');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->comment('Người tạo phiếu');
            $table->date('order_date')->comment('Ngày đặt hàng');
            $table->date('expected_delivery_date')->nullable()->comment('Ngày dự kiến nhận hàng');
            $table->enum('status', ['pending', 'ordered', 'partial_received', 'received', 'cancelled'])->default('pending')->comment('Trạng thái phiếu');
            $table->decimal('total_amount', 15, 2)->default(0)->comment('Tổng giá trị dự kiến của phiếu nhập');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamps();
        });
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->integer('quantity_ordered')->comment('Số lượng đặt');
            $table->decimal('cost_price_at_order', 15, 2)->comment('Giá nhập tại thời điểm đặt hàng');
            $table->integer('quantity_received')->default(0)->comment('Số lượng thực nhận');
            $table->timestamps();
        });
        Schema::create('online_orders', function (Blueprint $table) {
            $table->id();
            // Lưu thông tin khách hàng trực tiếp hoặc tạo bảng customers riêng và dùng khóa ngoại
            // $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('delivery_address');
            $table->decimal('total_amount', 15, 2)->comment('Tổng tiền hàng');
            $table->decimal('delivery_fee', 15, 2)->default(0)->comment('Phí giao hàng');
            $table->decimal('final_total', 15, 2)->comment('Tổng cộng cuối cùng');
            $table->enum('status', ['Mới', 'Đang xử lý', 'Đang giao hàng', 'Hoàn thành', 'Đã hủy'])->default('Mới');
            $table->string('payment_method')->default('COD'); // Mặc định COD
            $table->text('notes')->nullable()->comment('Ghi chú của khách hàng hoặc admin');
            $table->timestamps(); // created_at sẽ là thời gian đặt hàng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_management_tables');
    }
};
