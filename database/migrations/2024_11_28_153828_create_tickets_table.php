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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id') 
                ->constrained('reservations') 
                ->onDelete('cascade'); // If a reservation is deleted, delete the associated ticket
            $table->string('tariff_type'); // Type of tariff or ticket category (e.g., standard, discounted)
            $table->integer('seat'); // Seat as an integer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
