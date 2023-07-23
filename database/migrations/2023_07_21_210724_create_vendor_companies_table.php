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
        Schema::create('vendor_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text("company_type")->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('sub_category_id')->constrained('sub_categories');
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->double("latitude")->nullable();
            $table->double("longitude")->nullable();
            $table->string("logo")->nullable();
            $table->string("signature")->nullable();
            $table->boolean('is_admin_verified')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_companies');
    }
};
