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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('travel_company_id')->nullable()->constrained('travel_companies')->onDelete('set null');
            $table->string('bill_number')->unique();
            $table->datetime('bill_date');
            $table->dateTime('due_date')->nullable();
            $table->decimal('subtotal_room_charges', 12, 2);
            $table->decimal('subtotal_optional_services', 12, 2)->default(0.00);
            $table->decimal('tax_percentage_applied', 12, 2)->nullable();
            $table->decimal('tax_amount', 12, 2)->default(0.00);
            $table->decimal('discount_amount_applied', 12, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2);
            $table->decimal('amount_paid', 12, 2)->default(0.00);
            $table->string('payment_status')->default('unpaid'); // Enum: unpaid, partially_paid, paid, overdue, refunded
            $table->foreignId('generated_by_user_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
