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
        Schema::create('user_personals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('house_number');
            $table->string('street')->nullable();
            $table->foreignId('barangay_id')->constrained('barangays')->cascadeOnDelete();
            $table->string('city');
            $table->integer('years_resident');
            $table->foreignId('residence_type_id')->constrained('type_residences')->cascadeOnDelete();
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnDelete();
            $table->foreignId('type_id_id')->constrained('type_ids')->cascadeOnDelete();
            $table->enum('voters', ['yes', 'no']);
            $table->foreignId('educational_attainment_id')->constrained('educational_attainments')->cascadeOnDelete();
            $table->foreignId('religion_id')->constrained('religions')->cascadeOnDelete();
            $table->foreignId('civil_status_id')->constrained('civil_statuses')->cascadeOnDelete();
            $table->string('present_job')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_personals');
    }
};
