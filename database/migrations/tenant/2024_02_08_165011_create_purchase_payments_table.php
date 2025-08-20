<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_id');
            $table->string('date');
            $table->float('amount')->default(0);
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->text('receipt')->nullable();
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
    public function down(): void {
        Schema::dropIfExists('purchase_payments');
    }
};
