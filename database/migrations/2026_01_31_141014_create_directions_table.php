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
        Schema::create('directions', function (Blueprint $table) {
            $table->char('origin_iata_airport_code', 3);
            $table->char('dest_iata_airport_code', 3);
            $table->timestamps();

            // Composite primary key
            $table->primary(['origin_iata_airport_code', 'dest_iata_airport_code']);

            // Foreign keys
            $table->foreign('origin_iata_airport_code')
                ->references('iata_airport_code')
                ->on('airports')
                ->onDelete('cascade');

            $table->foreign('dest_iata_airport_code')
                ->references('iata_airport_code')
                ->on('airports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directions');
    }
};
