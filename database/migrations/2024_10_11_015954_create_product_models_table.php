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
        Schema::create('tab_products', function (Blueprint $table) {
            $table->id('pro_id');
            $table->string('pro_description', 150);
            $table->double('pro_sale_price', 8, 2);
            $table->double('pro_stock', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_products');
    }
};
