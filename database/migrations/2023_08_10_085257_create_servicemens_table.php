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
        Schema::create('servicemens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_company_id')->constrained('vendor_companies')->onDelete('cascade');
            $table->string('name');
            $table->string('phone')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained('sub_categories');
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->string('id_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicemens');
    }
};
