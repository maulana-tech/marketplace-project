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
        Schema::table('product_orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'success', 'cancelled'])->default('pending')->after('is_paid');
            $table->unsignedInteger('quantity')->default(1)->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->dropColumn(['status', 'quantity']);
        });
    }
};
