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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Nhân viên bán hàng (có thể null nếu là admin hoặc không ghi nhận)
            $table->decimal('total_amount', 15, 2); // Tổng tiền hóa đơn
            $table->string('payment_method')->default('Tiền mặt'); // Phương thức thanh toán
            // Cột sale_time sẽ dùng created_at của $table->timestamps()
            $table->timestamps();
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade'); // Khóa ngoại tới sales
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict'); // Khóa ngoại tới products (restrict để tránh xóa SP khi còn trong hóa đơn)
            $table->integer('quantity'); // Số lượng bán
            $table->decimal('price_at_sale', 15, 2); // Giá bán tại thời điểm bán
            // total_item_price có thể tính toán động hoặc lưu trữ nếu cần
            // $table->decimal('total_item_price', 15, 2);
            $table->timestamps(); // Lưu thời điểm item được thêm nếu cần, hoặc bỏ đi
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_management_tables');
    }
};
