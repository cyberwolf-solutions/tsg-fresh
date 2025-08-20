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
        Schema::create('cash_in_hand', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique(); // one record per day
            $table->float('opening_cash')->default(0);
            $table->float('closing_cash')->nullable();
            $table->float('total_cash_received')->default(0); // calculated from orders_payments
            $table->float('balance')->nullable(); // closing_cash - (opening_cash + total_cash_received)
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
        Schema::dropIfExists('cash_in_hand');
    }
};
