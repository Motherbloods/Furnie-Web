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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            // ID unik dari Midtrans
            $table->string('order_id')->unique();

            // Status dari Midtrans
            $table->enum('status', ['pending', 'paid', 'expired', 'canceled'])->default('pending');

            // Status internal order
            $table->enum('order_status', ['menunggu_konfirmasi', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu_konfirmasi');

            // Data total belanja
            $table->decimal('total_amount', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0); // meskipun belum ekspedisi, bisa jadi pickup ada biaya

            // Metode pengambilan/pengiriman
            $table->string('shipping_method'); // contoh: "ambil di tempat", "antar manual"

            // Alamat kirim atau keterangan tempat ambil
            $table->text('shipping_address');

            // Data pembayaran
            $table->string('payment_type')->nullable(); // e.g. "bank_transfer", "gopay"
            $table->string('payment_token')->nullable(); // Snap Token (opsional)

            // Opsional
            $table->text('notes')->nullable(); // Catatan pembeli

            // Waktu-waktu penting
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->text('cancel_reason')->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
