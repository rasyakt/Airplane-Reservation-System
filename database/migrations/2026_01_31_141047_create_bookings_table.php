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
        Schema::create('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('flight_call');
            $table->unsignedBigInteger('aircraft_id');
            $table->unsignedBigInteger('seat_id');
            $table->string('confirmation_code', 20)->unique();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();

            $table->primary(['client_id', 'flight_call', 'aircraft_id', 'seat_id']);

            // Unique constraint to prevent double booking of same seat on same flight
            $table->unique(['flight_call', 'seat_id'], 'unique_flight_seat');

            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('cascade');

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
        Schema::dropIfExists('bookings');
    }
};
