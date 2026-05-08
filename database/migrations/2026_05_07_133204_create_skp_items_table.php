<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('p2kp_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p2kp_id')->constrained('p2kps')->onDelete('cascade');
            $table->text('activity');
            $table->decimal('credit_score', 8, 3)->nullable();
            
            // Targets
            $table->integer('target_qty');
            $table->string('target_output');
            $table->integer('target_quality');
            $table->integer('target_time');
            $table->string('target_time_unit');
            
            // Realizations
            $table->integer('real_qty')->nullable();
            $table->integer('real_quality')->nullable();
            $table->integer('real_time')->nullable();
            $table->decimal('real_cost', 15, 2)->nullable();
            
            $table->string('type')->default('utama'); // utama, tambahan, kreatifitas
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('p2kp_items');
    }
};
