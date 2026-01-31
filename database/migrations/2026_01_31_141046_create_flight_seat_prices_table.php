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
        Schema::create('flight_seat_prices', function (Blueprint $table) {
            $table->unsignedBigInteger('flight_call');
            $table->unsignedBigInteger('aircraft_id');
            $table->unsignedBigInteger('seat_id');
            $table->decimal('price_usd', 10, 2);
            $table->timestamps();

            $table->primary(['flight_call', 'aircraft_id', 'seat_id']);

            $table->foreign('flight_call')
                ->references('flight_call')
                ->on('flights')
                ->onDelete('cascade');

            $table->foreign('aircraft_id')
                ->references('aircraft_id')
                ->on('aircraft')
                ->onDelete('cascade');

            $table->foreign('seat_id')
                ->references('seat_id')
                ->on('aircraft_seats')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_seat_prices');
    }
};
