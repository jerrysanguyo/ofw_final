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
        Schema::create('archive_abroads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('archive_personals')->cascadeOnDelete();
            $table->enum('job_type', ['landbased', 'seabased']);
            $table->foreignId('job_id')->nullable()->constrained('jobs')->nullOnDelete();
            $table->foreignId('sub_job_id')->nullable()->constrained('sub_jobs')->nullOnDelete();
            $table->foreignId('continent_id')->nullable()->constrained('continents')->nullOnDelete();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->nullOnDelete();
            $table->integer('abroad_years');
            $table->date('date_departure')->nullable();
            $table->date('date_arrival')->nullable();
            $table->foreignId('owwa_id')->nullable()->constrained('owwas')->nullOnDelete();
            $table->enum('intent_return', ['yes', 'no']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_abroads');
    }
};
