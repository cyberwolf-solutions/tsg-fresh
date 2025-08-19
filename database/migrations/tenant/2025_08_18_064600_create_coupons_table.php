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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();           // coupon code like WELCOME10
            $table->enum('type', ['percentage', 'fixed']); // discount type
            $table->decimal('value', 10, 2);            // value (10 = 10% or 10 = Rs.10 depending on type)
            $table->date('expiry_date')->nullable();    // expiration date
            $table->integer('max_uses')->nullable();    // total allowed uses (null = unlimited)
            $table->integer('used_count')->default(0);  // how many times used
            $table->boolean('active')->default(true);   // enable/disable
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
        Schema::dropIfExists('coupons');
    }
};
