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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade');
            $table->foreignId('travel_company_id')->nullable()->constrained('travel_companies')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('restrict');
            $table->datetime('check_in_date');
            $table->datetime('check_out_date');
            $table->integer('number_of_guests')->default(1);
            $table->string('status'); // Enum: pending_payment, confirmed, checked_in, checked_out, cancelled_customer, cancelled_system, no_show, block_booking_pending_names
            $table->boolean('has_credit_card_guarantee')->default(false);
            $table->text('special_requests')->nullable();
            $table->timestamp('actual_check_in_timestamp')->nullable();
            $table->timestamp('actual_check_out_timestamp')->nullable();
            $table->foreignId('booked_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('total_estimated_room_charge', 12, 2);
            $table->decimal('applied_discount_percentage', 12, 2)->nullable();
            $table->boolean('is_suite_booking')->default(false);
            $table->string('suite_booking_period')->nullable(); // Enum: weekly, monthly
            $table->decimal('suite_rate_applied', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
