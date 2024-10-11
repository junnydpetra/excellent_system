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
        Schema::create('tab_images', function (Blueprint $table) {
            $table->id('ima_id');
            $table->string('ima_path', 255);
            $table->unsignedBigInteger('ima_pro_id_fk');
            $table->foreign('ima_pro_id_fk')->references('pro_id')
                                            ->on('tab_products')
                                            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_images');
    }
};
