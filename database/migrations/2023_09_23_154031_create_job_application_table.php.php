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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('linked_in_link')->nullable();
            $table->date('visa_validity')->nullable();
            $table->string('gender')->nullable();
            $table->foreignId('job_type_id')->constrained('job_type')->onDelete('cascade');
            $table->enum('experience_level', ['experienced', 'fresher']);  
            $table->foreignId('current_job_id')->constrained('job')->onDelete('cascade');
            $table->foreignId('desire_job_id')->constrained('job')->onDelete('cascade');
            $table->foreignId('visa_type_id')->constrained('visa')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('cv')->nullable();
            $table->string('proof')->nullable();
            $table->string('note')->nullable();
            $table->string('present_company')->nullable();
            $table->double('expected_salary', 8, 2)->nullable();
            $table->double('presant_salary', 8, 2)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
