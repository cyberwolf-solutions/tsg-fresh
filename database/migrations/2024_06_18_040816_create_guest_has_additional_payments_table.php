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
        Schema::create('guest_has_additional_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('customer_id');
            $table->integer('additional_payment_id');
            $table->integer('price');
            $table->string("created_by");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_has_additional_payments');
    }
};
