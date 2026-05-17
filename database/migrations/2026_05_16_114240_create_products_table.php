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
    Schema::create('products', function (Blueprint $table) {

        $table->id();

        // RELATION
        $table->foreignId('category_id')
            ->constrained()
            ->cascadeOnDelete();

        // BASIC
        $table->string('name');

        $table->string('slug')->unique();

        $table->text('short_description')->nullable();

        $table->longText('description')->nullable();

        // PRICING
        $table->decimal('price', 12, 2);

        $table->decimal('discount_price', 12, 2)
            ->nullable();

        // INVENTORY
        $table->integer('stock')
            ->default(0);

        $table->string('sku')
            ->nullable();

        // MEDIA
        $table->string('thumbnail')
            ->nullable();

        // STATUS
        $table->boolean('is_active')
            ->default(true);

        $table->boolean('is_featured')
            ->default(false);

        // SEO
        $table->string('meta_title')
            ->nullable();

        $table->text('meta_description')
            ->nullable();

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
