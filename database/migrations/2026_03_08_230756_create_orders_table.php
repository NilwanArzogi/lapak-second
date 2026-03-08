<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pembeli');
        $table->string('email')->nullable();
        $table->string('nomor_hp');
        $table->text('item_pesanan'); // Menyimpan list barang dalam format JSON
        $table->decimal('total_harga', 15, 2);
        $table->string('metode_pembayaran');
        $table->string('status')->default('pending'); // pending, dikemas, dikirim, selesai
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

