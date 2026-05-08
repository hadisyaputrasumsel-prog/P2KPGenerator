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
            $table->integer('real_qty')->nullable();
            $table->integer('real_quality')->nullable();
            $table->integer('real_time')->nullable();
            $table->decimal('real_cost', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p2kp_items', function (Blueprint $table) {
            $table->dropColumn(['real_qty', 'real_quality', 'real_time', 'real_cost']);
        });
    }
};
