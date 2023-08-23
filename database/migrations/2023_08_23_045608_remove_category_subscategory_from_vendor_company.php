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
        Schema::table('vendor_companies', function (Blueprint $table) {
            //
            $table->dropForeign('vendor_companies_category_id_foreign');
            $table->dropForeign('vendor_companies_sub_category_id_foreign');
            $table->dropColumn('category_id');
            $table->dropColumn('sub_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_companies', function (Blueprint $table) {
            //
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('sub_category_id')->constrained('sub_categories');
        });
    }
};
