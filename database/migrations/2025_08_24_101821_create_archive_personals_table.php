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
        Schema::create('archive_personals', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('house_number');
            $table->string('street')->nullable();
            $table->foreignId('barangay_id')->nullable()->constrained('barangays')->nullOnDelete();
            $table->string('city');
            $table->integer('years_resident');
            $table->foreignId('residence_type_id')->nullable()->constrained('type_residences')->nullOnDelete();
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('type_ids')->nullOnDelete();
            $table->enum('voters', ['yes', 'no']);
            $table->foreignId('educational_attainment_id')->nullable()->constrained('educational_attainments')->nullOnDelete();
            $table->foreignId('religion_id')->nullable()->constrained('religions')->nullOnDelete();
            $table->foreignId('civil_status_id')->nullable()->constrained('civil_statuses')->nullOnDelete();
            $table->string('present_job')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_personals');
    }
};
