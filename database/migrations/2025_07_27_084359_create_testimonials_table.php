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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_order_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('buyer_id'); // pembeli yang memberikan testimoni
            $table->unsignedBigInteger('seller_id'); // penjual yang menerima testimoni
            $table->unsignedTinyInteger('rating')->default(5); // rating 1-5
            $table->text('comment'); // komentar testimoni
            $table->timestamps();
            
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
