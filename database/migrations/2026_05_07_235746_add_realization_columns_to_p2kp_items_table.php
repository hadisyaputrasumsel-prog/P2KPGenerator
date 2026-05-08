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
        $table = Schema::hasTable('p2kp_items') ? 'p2kp_items' : 'skp_items';
        
        if (Schema::hasTable($table)) {
            Schema::table($table, function (Blueprint $table) use ($table) {
                if (!Schema::hasColumn($table, 'real_qty')) {
                    $table->integer('real_qty')->nullable()->after('target_time_unit');
                    $table->integer('real_quality')->nullable()->after('real_qty');
                    $table->integer('real_time')->nullable()->after('real_quality');
                    $table->decimal('real_cost', 15, 2)->nullable()->after('real_time');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table = Schema::hasTable('p2kp_items') ? 'p2kp_items' : 'skp_items';
        
        if (Schema::hasTable($table)) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['real_qty', 'real_quality', 'real_time', 'real_cost']);
            });
        }
    }
};

