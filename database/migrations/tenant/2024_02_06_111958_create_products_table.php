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

            // Core product fields
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();

            // Identification
            $table->string('product_code')->unique();
            $table->string('barcode')->nullable();

            // Brand and unit
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('product_unit')->nullable(); // FK to units table if needed

            // Pricing & Stock
            $table->float('cost')->default(0);
            $table->float('product_price')->default(0);
            $table->float('qty')->default(0);

            // Tax-related
            $table->float('tax')->nullable();
            $table->string('tax_method')->nullable();   // e.g., 'exclusive', 'inclusive'
            $table->string('tax_status')->nullable();   // e.g., 'taxable', 'non-taxable'
            $table->string('tax_class')->nullable();    // e.g., 'standard', 'reduced'

            // Type (simple, grouped, variable)
            $table->enum('product_type', ['simple', 'grouped', 'variable'])->default('simple');
            $table->enum('status', ['public', 'private'])->default('public')->after('product_type');
            // Audit
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
