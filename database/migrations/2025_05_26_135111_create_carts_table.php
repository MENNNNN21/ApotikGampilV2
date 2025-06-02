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
       Schema::create('carts', function (Blueprint $table) {
    $table->id();  // id primary key
    $table->unsignedBigInteger('user_id');  // foreign key ke users.id
    $table->unsignedBigInteger('product_id');  // foreign key ke products.id
    $table->integer('quantity');
    $table->timestamps();

    // Membuat foreign key constraint
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('product_id')->references('id')->on('obats')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
