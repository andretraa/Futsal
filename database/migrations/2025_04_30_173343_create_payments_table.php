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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id');
            $table->string('order_id')->unique();
            $table->string('payment_method');
            $table->dateTime('transaction_time');
            $table->dateTime('transaction_status');
            $table->integer('gross_amount');
            $table->string('va_numbers')->nullable();
            $table->string('pdf_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
