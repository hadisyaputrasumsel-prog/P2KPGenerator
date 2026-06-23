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
        Schema::table('p2kp_items', function (Blueprint $table) {
            $table->decimal('real_credit_score', 8, 3)->nullable()->after('credit_score');
            $table->string('real_output')->nullable()->after('target_output');
            $table->string('real_time_unit')->nullable()->after('target_time_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p2kp_items', function (Blueprint $table) {
            $table->dropColumn(['real_credit_score', 'real_output', 'real_time_unit']);
        });
    }
};
