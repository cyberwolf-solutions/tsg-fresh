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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Link to cart
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')
                ->references('id')->on('carts')
                ->onDelete('cascade');

            // Product
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            // Optional variant
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->foreign('variant_id')
                ->references('id')->on('product_variants')
                ->onDelete('set null');

            // Direct inventory reference (if needed for batch/expiry tracking)
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')
                ->references('id')->on('inventory')
                ->onDelete('set null');

            // Cart values
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0); // unit price snapshot
            $table->decimal('total', 12, 2)->default(0); // price * qty
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
