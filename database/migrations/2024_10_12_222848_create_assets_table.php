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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('asset_types_id')->constrained('asset_types')->onDelete('cascade');
            $table->string('asset_name')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('service_category_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('cascade');
            $table->date('reminder_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->date('date')->nullable();
            $table->string('email')->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_phone_number')->nullable();
            $table->string('alternative_name')->nullable();
            $table->string('alternative_phone')->nullable();
            $table->string('uploads')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
