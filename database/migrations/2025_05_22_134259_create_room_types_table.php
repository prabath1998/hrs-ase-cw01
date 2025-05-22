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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->integer('occupancy_limit'); // Maximum number of guests allowed
            $table->decimal('base_price_per_night', 12, 2);
            $table->boolean('is_suite')->default(false);    // Indicates if the room type is more luxurious
            $table->decimal('suite_weekly_rate', 12, 2)->nullable();
            $table->decimal('suite_monthly_rate', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
