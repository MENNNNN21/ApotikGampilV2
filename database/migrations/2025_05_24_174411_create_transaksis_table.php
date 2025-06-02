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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('total', 12, 2);
        $table->enum('status', ['dibayar', 'belum_dibayar', 'selesai'])->default('belum_dibayar');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('transaksis');
}
};
