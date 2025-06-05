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
        Schema::create('optional_service_reservation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->foreignId('optional_service_id')->constrained('optional_services')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_booking', 12, 2);
            $table->timestamps();

            $table->unique(['reservation_id', 'optional_service_id'], 'reservation_service_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optional_service_reservation');
    }
};
