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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên danh mục (duy nhất)
            $table->text('description')->nullable(); // Mô tả (tùy chọn)
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên sản phẩm
            $table->string('sku')->unique()->nullable(); // Mã SKU (duy nhất, tùy chọn)
            $table->string('barcode')->unique()->nullable(); // Mã vạch (duy nhất, tùy chọn)
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Khóa ngoại tới category, nếu xóa category thì set null
            $table->string('unit')->nullable(); // Đơn vị tính (cái, hộp, kg...)
            $table->decimal('purchase_price', 15, 2)->default(0); // Giá nhập (nên dùng decimal cho tiền tệ)
            $table->decimal('selling_price', 15, 2); // Giá bán
            $table->integer('stock_quantity')->default(0); // Số lượng tồn kho
            $table->integer('min_stock_level')->default(0); // Mức tồn kho tối thiểu
            $table->string('image_url')->nullable(); // Link hình ảnh
            $table->text('description')->nullable(); // Mô tả sản phẩm
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_tables');
    }
};
