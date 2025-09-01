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
        Schema::create('archive_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('archive_personals')->cascadeOnDelete();
            $table->string('full_name');
            $table->foreignId('relation_id')->nullable()->constrained('relations')->nullOnDelete();
            $table->date('date_of_birth');
            $table->string('work')->nullable();
            $table->integer('income')->nullable();
            $table->enum('voters', ['yes', 'no']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_families');
    }
};
