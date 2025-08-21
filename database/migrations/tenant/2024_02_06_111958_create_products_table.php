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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();

            $table->string('product_code')->unique();
            $table->string('barcode')->nullable();

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('product_unit')->nullable();

            $table->float('cost')->default(0);
            $table->float('product_price')->default(0);
            $table->float('qty')->default(0);

            $table->float('tax')->default(0);
            $table->string('tax_method')->nullable();
            $table->string('tax_status')->nullable();
            $table->string('tax_class')->nullable();

            $table->enum('product_type', ['simple', 'grouped', 'variable'])->default('simple');

            $table->enum('status', ['public', 'private'])->default('public');
            $table->float('final_price')->default(0);

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
        Schema::dropIfExists('products');
    }
};
