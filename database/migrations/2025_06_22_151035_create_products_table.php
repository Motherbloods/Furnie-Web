<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->enum('kategori', ['meja', 'kursi', 'lemari', 'kasur', 'sofa', 'rak', 'dekorasi']);
            $table->text('description')->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->float('rating')->default(0);
            $table->integer('reviews')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('stock');
            $table->json('specifications')->nullable();
            $table->json('features')->nullable();
            $table->json('images')->nullable();
            $table->string('image')->nullable();
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
