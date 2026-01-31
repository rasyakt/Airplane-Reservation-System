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
        Schema::create('aircraft', function (Blueprint $table) {
            $table->id('aircraft_id');
            $table->unsignedBigInteger('aircraft_manufacturer_id');
            $table->string('model', 45);
            $table->timestamps();

            $table->foreign('aircraft_manufacturer_id')
                ->references('aircraft_manufacturer_id')
                ->on('aircraft_manufacturers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft');
    }
};
