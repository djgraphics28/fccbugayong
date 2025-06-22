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
        Schema::create('scholarship_registrations', function (Blueprint $table) {
            $table->id();
            // Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->date('birth_date');
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->text('address');

            // Parents and Guardian Info
            $table->string('father_name');
            $table->string('father_occupation')->nullable();
            $table->string('father_contact')->nullable();

            $table->string('mother_name');
            $table->string('mother_occupation')->nullable();
            $table->string('mother_contact')->nullable();

            $table->string('guardian_name')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_contact')->nullable();

            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_registrations');
    }
};
