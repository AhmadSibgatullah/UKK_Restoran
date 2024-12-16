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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories');
            $table->string('product_name', 100);
            $table->text('description');
            $table->integer('price');
            $table->integer('stock_quantity');
            $table->string('image1_url');
            $table->string('image2_url')->nullable();
            $table->string('image3_url')->nullable();
            $table->string('image4_url')->nullable();
            $table->string('image5_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
