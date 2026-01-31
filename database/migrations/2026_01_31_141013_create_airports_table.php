<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->char('iata_airport_code', 3)->primary();
            $table->string('name', 45);
            $table->string('city', 45);
            $table->char('iata_country_code', 2);
            $table->timestamps();

            $table->foreign('iata_country_code')
                ->references('iata_country_code')
                ->on('countries')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
