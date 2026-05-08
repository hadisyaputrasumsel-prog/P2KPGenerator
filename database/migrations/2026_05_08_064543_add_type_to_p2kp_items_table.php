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
            $table->string('type')->default('utama')->after('activity'); // utama, tambahan, kreatifitas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p2kp_items', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
