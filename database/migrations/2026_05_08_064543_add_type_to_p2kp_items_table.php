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
        
        if (Schema::hasTable($table) && !Schema::hasColumn($table, 'type')) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('type')->default('utama')->after('real_cost');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table = Schema::hasTable('p2kp_items') ? 'p2kp_items' : 'skp_items';
        
        if (Schema::hasTable($table) && Schema::hasColumn($table, 'type')) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }
};

