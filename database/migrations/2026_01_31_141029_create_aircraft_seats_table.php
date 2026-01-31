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
        Schema::create('aircraft_seats', function (Blueprint $table) {
            $table->id('seat_id');
            $table->unsignedBigInteger('aircraft_id');
            $table->unsignedBigInteger('travel_class_id');
            $table->timestamps();

            $table->foreign('aircraft_id')
                ->references('aircraft_id')
                ->on('aircraft')
                ->onDelete('cascade');

            $table->foreign('travel_class_id')
                ->references('travel_class_id')
                ->on('travel_classes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft_seats');
    }
};
