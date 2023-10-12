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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number'); 
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->string('service_name');
            $table->string('service_reference_number')->nullable();
            $table->string('service_description')->nullable();
            $table->string('service_amount');
            $table->string('signature')->nullable();
            $table->string('advance_amount')->nullable();
            $table->boolean('site_inspection')->default(false);
            $table->string('status')->default('created');//created, sent, accepted, rejected, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
