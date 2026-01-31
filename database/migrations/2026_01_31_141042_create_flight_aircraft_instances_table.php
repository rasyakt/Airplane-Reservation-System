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
        Schema::create('flight_aircraft_instances', function (Blueprint $table) {
            $table->unsignedBigInteger('flight_call');
            $table->unsignedBigInteger('aircraft_instance_id');
            $table->timestamps();

            $table->primary(['flight_call', 'aircraft_instance_id']);

            $table->foreign('flight_call')
                ->references('flight_call')
                ->on('flights')
                ->onDelete('cascade');

            $table->foreign('aircraft_instance_id')
                ->references('aircraft_instance_id')
                ->on('aircraft_instances')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_aircraft_instances');
    }
};
