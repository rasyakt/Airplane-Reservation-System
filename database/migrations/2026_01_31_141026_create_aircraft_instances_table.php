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
        Schema::create('aircraft_instances', function (Blueprint $table) {
            $table->id('aircraft_instance_id');
            $table->unsignedBigInteger('aircraft_id');
            $table->timestamps();

            $table->foreign('aircraft_id')
                ->references('aircraft_id')
                ->on('aircraft')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft_instances');
    }
};
