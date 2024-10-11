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
        Schema::create('tab_order_product', function (Blueprint $table) {
            $table->id('op_id');
            $table->unsignedBigInteger('op_order_id_fk');
            $table->unsignedBigInteger('op_product_id_fk');
            $table->foreign('op_order_id_fk')->references('ord_id')
                                             ->on('tab_orders')
                                             ->onDelete('cascade');
            $table->foreign('op_product_id_fk')->references('pro_id')
                                               ->on('tab_products')
                                               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_order_product');
    }
};
