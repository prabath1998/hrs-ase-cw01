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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('contact_email')->nullable()->unique();
            $table->string('phone_number')->nullable();
            $table->text('image');
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->dateTime('default_check_in_time');
            $table->dateTime('default_check_out_time');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
