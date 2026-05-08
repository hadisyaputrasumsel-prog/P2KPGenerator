<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('skps') && !Schema::hasTable('p2kps')) {
            Schema::rename('skps', 'p2kps');
        }
        
        if (Schema::hasTable('skp_items') && !Schema::hasTable('p2kp_items')) {
            Schema::rename('skp_items', 'p2kp_items');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('p2kps') && !Schema::hasTable('skps')) {
            Schema::rename('p2kps', 'skps');
        }
        
        if (Schema::hasTable('p2kp_items') && !Schema::hasTable('skp_items')) {
            Schema::rename('p2kp_items', 'skp_items');
        }
    }
};

