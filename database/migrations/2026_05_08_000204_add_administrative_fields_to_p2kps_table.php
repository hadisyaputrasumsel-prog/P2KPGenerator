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
        $table = Schema::hasTable('p2kps') ? 'p2kps' : 'skps';
        
        if (Schema::hasTable($table)) {
            Schema::table($table, function (Blueprint $table) use ($table) {
                if (!Schema::hasColumn($table, 'recommendation')) {
                    $table->text('recommendation')->nullable()->after('leadership');
                    $table->text('objection')->nullable()->after('recommendation');
                    $table->text('response')->nullable()->after('objection');
                    $table->text('decision')->nullable()->after('response');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table = Schema::hasTable('p2kps') ? 'p2kps' : 'skps';
        
        if (Schema::hasTable($table)) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['recommendation', 'objection', 'response', 'decision']);
            });
        }
    }
};

