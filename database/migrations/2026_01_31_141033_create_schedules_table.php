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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->char('origin_iata_airport_code', 3);
            $table->char('dest_iata_airport_code', 3);
            $table->timestamp('departure_time_gmt');
            $table->timestamp('arrival_time_gmt');
            $table->string('callsign');
            $table->timestamps();

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
        Schema::dropIfExists('schedules');
    }
};
