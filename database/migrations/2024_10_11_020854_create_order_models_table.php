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
        Schema::create('tab_orders', function (Blueprint $table) {
            $table->id('ord_id');
            $table->unsignedBigInteger('ord_client_id_fk');
            $table->foreign('ord_client_id_fk')->references('cli_id')
                                               ->on('tab_clients')
                                               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_orders');
    }
};
