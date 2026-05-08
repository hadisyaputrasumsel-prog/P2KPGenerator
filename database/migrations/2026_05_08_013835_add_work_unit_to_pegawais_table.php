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
        if (Schema::hasTable('pegawais') && !Schema::hasColumn('pegawais', 'work_unit')) {
            Schema::table('pegawais', function (Blueprint $table) {
                $table->string('work_unit')->nullable()->after('unit');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pegawais') && Schema::hasColumn('pegawais', 'work_unit')) {
            Schema::table('pegawais', function (Blueprint $table) {
                $table->dropColumn('work_unit');
            });
        }
    }
};

