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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('path_file');
            $table->unsignedInteger('quantity')->default(0)->after('about');
            $table->string('size')->nullable()->after('quantity'); // untuk sepatu, baju
            $table->string('color')->nullable()->after('size'); // warna produk
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'size', 'color']);
            $table->string('path_file')->after('about');
        });
    }
};
