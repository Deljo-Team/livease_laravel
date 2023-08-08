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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vendor_company_id')->constrained('vendor_companies');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->enum('type', ['debit', 'credit']);
            $table->double('amount', 8, 2);
            $table->double('balance', 8, 2)->nullable();
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
