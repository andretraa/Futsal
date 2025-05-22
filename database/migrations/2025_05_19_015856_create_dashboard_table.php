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
        Schema::create('dashboard', function (Blueprint $table) {
    $table->id();
    $table->foreignId('users_id')->constrained()->onDelete('cascade');
    $table->foreignId('fields_id')->constrained()->onDelete('cascade');
    $table->foreignId('schedules_id')->constrained()->onDelete('cascade');
    $table->decimal('total_price', 15, 2);
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard');
    }
};
