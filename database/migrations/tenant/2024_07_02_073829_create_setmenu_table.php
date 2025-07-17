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
        Schema::create('setmenu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category_id');
            $table->integer('setmenu_type');
            $table->enum('type', ['KOT', 'BOT'])->default('KOT');
            $table->integer('setmenu_meal_type')->default(0);
            $table->float('unit_price_lkr')->default(0);
            $table->float('unit_price_usd')->default(0);
            $table->float('unit_price_eu')->default(0);
            $table->string('image_url')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('setmenu');
    }
};
