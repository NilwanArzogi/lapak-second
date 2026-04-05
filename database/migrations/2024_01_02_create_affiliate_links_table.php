<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code')->unique();           // kode unik referral
            $table->enum('commission_type', ['percent', 'flat'])->default('percent');
            // percent = nilai persen (misal 5 = 5%), flat = nominal rupiah (misal 10000 = Rp 10.000)
            $table->decimal('commission_value', 15, 2)->default(5.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_links');
    }
};
