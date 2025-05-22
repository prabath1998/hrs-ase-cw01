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
        Schema::create('travel_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('set null');
            $table->string('company_name')->unique();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable()->unique();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('registration_number')->nullable();
            $table->decimal('negotiated_discount_percentage', 12, 2)->nullable(); // Discount percentage for the travel company
            $table->string('payment_info_token')->nullable();
            $table->string('credit_card_last_four', 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_companies');
    }
};
