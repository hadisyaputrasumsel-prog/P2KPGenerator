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
        if (Schema::hasTable('pegawais')) {
            Schema::table('pegawais', function (Blueprint $table) {
                if (Schema::hasColumn('pegawais', 'nik')) {
                    $table->renameColumn('nik', 'nuptk');
                } elseif (Schema::hasColumn('pegawais', 'nip')) {
                    $table->renameColumn('nip', 'nuptk');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pegawais') && Schema::hasColumn('pegawais', 'nuptk')) {
            Schema::table('pegawais', function (Blueprint $table) {
                $table->renameColumn('nuptk', 'nuptk'); // Should actually be nik or nip depending on what it was
            });
        }
    }
};

