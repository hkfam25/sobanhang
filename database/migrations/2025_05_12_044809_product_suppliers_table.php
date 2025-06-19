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
        Schema::create('product_suppliers', function (Blueprint $table) {
            $table->id(); // Hoặc dùng composite primary key
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Khóa ngoại tới products
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // Khóa ngoại tới suppliers
            $table->string('supplier_product_code')->nullable()->comment('Mã SP của riêng NCC');
            $table->decimal('cost_price', 15, 2)->comment('Giá nhập từ NCC này');
            $table->boolean('is_preferred')->default(false)->comment('Là NCC ưu tiên cho SP này?');
            $table->timestamps();

            // Đảm bảo cặp product_id và supplier_id là duy nhất
            $table->unique(['product_id', 'supplier_id']);
            // Nếu không dùng $table->id(), bạn có thể định nghĩa khóa chính phức hợp:
            // $table->primary(['product_id', 'supplier_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
