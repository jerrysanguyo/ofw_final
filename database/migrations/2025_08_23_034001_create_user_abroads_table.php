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
        Schema::create('user_abroads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user_personals')->cascadeOnDelete();
            $table->enum('job_type', ['landbased', 'seabased']);
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('sub_job_id')->constrained('sub_jobs')->cascadeOnDelete();
            $table->foreignId('continent_id')->constrained('continents')->cascadeOnDelete();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->foreignId('contract_id')->constrained('contracts')->cascadeOnDelete();
            $table->integer('abroad_years');
            $table->date('date_departure')->nullable();
            $table->date('date_arrival')->nullable();
            $table->foreignId('owwa_id')->constrained('owwas')->cascadeOnDelete();
            $table->enum('intent_return', ['yes', 'no']);
            $table->enum('status', ['active','inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_abroads');
    }
};
