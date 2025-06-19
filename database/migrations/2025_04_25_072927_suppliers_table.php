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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên nhà cung cấp
            $table->string('contact_person')->nullable(); // Người liên hệ
            $table->string('phone')->nullable(); // Số điện thoại
            $table->string('email')->nullable(); // Email
            $table->text('address')->nullable(); // Địa chỉ
            $table->text('notes')->nullable(); // Ghi chú thêm
            $table->timestamps();
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
