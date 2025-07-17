<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('checkin');
            $table->string('checkout');
            $table->string('ta');
            $table->integer('no_of_adults')->default(0);
            $table->integer('no_of_children')->default(0);
            $table->decimal('total_lkr', 10, 2)->default(0);
$table->decimal('total_usd', 10, 2)->default(0);
$table->decimal('total_eur', 10, 2)->default(0);

            $table->enum('status', ['Pending', 'OnGoing', 'Complete' ,'Cancelled'])->default('Pending');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('cancel_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
