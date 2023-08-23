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
        Schema::create('vendor_company_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_company_id')->constrained('vendor_companies');
            $table->foreignId('sub_category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_company_sub_categories');
    }
};
