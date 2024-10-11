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
        Schema::create('tab_clients', function (Blueprint $table) {
            $table->id('cli_id');
            $table->string('cli_api_id', 50);
            $table->string('cli_company_name', 150);
            $table->string('cli_cnpj', 14);
            $table->string('cli_email', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_clients');
    }
};
