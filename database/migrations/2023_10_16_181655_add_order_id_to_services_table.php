<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('user_id');
            $table->string('service')->nullable()->after('order_id');
            $table->enum('status', ['complete', 'rejected', 'created', 'pending'])->after('service');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('service');
            $table->dropColumn('status');
        });
    }
};
