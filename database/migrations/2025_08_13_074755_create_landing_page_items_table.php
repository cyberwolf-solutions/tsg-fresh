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
        Schema::create('landing_page_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('landing_page_sections');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('order')->default(0);
            $table->json('style')->nullable(); // For custom CSS styles
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_items');
    }
};
