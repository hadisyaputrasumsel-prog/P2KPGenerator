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
        $tableName = Schema::hasTable('p2kps') ? 'p2kps' : 'skps';
        
        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'service_orientation')) {
                    $table->decimal('service_orientation', 5, 2)->default(0);
                    $table->decimal('integrity', 5, 2)->default(0);
                    $table->decimal('commitment', 5, 2)->default(0);
                    $table->decimal('discipline', 5, 2)->default(0);
                    $table->decimal('cooperation', 5, 2)->default(0);
                    $table->decimal('leadership', 5, 2)->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = Schema::hasTable('p2kps') ? 'p2kps' : 'skps';
        
        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['service_orientation', 'integrity', 'commitment', 'discipline', 'cooperation', 'leadership']);
            });
        }
    }
};

