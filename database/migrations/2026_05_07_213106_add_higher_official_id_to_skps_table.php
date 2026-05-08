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
        // Try both table names in case renaming hasn't happened yet or already happened
        $table = Schema::hasTable('p2kps') ? 'p2kps' : 'skps';
        
        if (Schema::hasTable($table) && !Schema::hasColumn($table, 'higher_official_id')) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('higher_official_id')->nullable()->after('rating_official_id')->constrained('pegawais')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table = Schema::hasTable('p2kps') ? 'p2kps' : 'skps';
        
        if (Schema::hasTable($table) && Schema::hasColumn($table, 'higher_official_id')) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['higher_official_id']);
                $table->dropColumn('higher_official_id');
            });
        }
    }
};

