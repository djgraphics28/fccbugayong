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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->timestamp('time_in');
            $table->date('service_date'); // Store the Sunday service date
            $table->string('service_type')->default('Sunday'); // Type of service (Sunday by default)
            $table->boolean('is_present')->default(true); // Track attendance status
            $table->text('notes')->nullable(); // Optional notes about attendance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
