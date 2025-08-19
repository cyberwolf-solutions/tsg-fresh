<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('web_customer_id')->nullable()->default(null);
            $table->dateTime('order_date');
            $table->enum('payment_status', ['Pending', 'InProgress', 'Complete'])->default('Pending');
            $table->enum('status', [
                'Pending',
                'Confirmed',
                'Packed',
                'Out for Delivery',
                'Delivered',
                'Issued',
                'Complete'
            ])->default('Pending');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('vat', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->unsignedBigInteger('coupon_id')->nullable(); // store applied coupon ID
            $table->string('coupon_code')->nullable();           // store applied coupon code
            $table->decimal('coupon_value', 10, 2)->nullable();  // store numeric value of discount
            $table->enum('coupon_type', ['fixed', 'percentage'])->nullable(); // type
            $table->string('source')->default('POS'); // 'POS' or 'WEB'
            $table->string('delivery_method')->nullable(); // 'Pickup' or 'Shipping'
            $table->string('payment_method')->nullable(); // 'COD', 'Card', 'Bank'
            $table->text('delivery_address')->nullable(); // For shipping orders
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
        Schema::dropIfExists('orders');
    }
};
