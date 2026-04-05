<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_link_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->decimal('order_total', 15, 2);
            $table->enum('commission_type', ['percent', 'flat']);
            $table->decimal('commission_value', 15, 2);
            $table->decimal('commission_amount', 15, 2);  // hasil komisi
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->timestamps();
        });

        // Tambah ref_code ke orders agar bisa track dari mana order datang
        Schema::table('orders', function ($table) {
            $table->string('ref_code')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('ref_code');
        });
        Schema::dropIfExists('affiliate_commissions');
    }
};
