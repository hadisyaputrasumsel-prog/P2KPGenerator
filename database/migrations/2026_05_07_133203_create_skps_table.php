<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('p2kps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('rating_official_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('higher_official_id')->nullable()->constrained('pegawais')->onDelete('cascade');
            $table->date('period_start');
            $table->date('period_end');
            $table->string('location');
            $table->date('date_signed');
            
            // Performance Elements (Unsur Perilaku)
            $table->decimal('service_orientation', 5, 2)->default(0);
            $table->decimal('integrity', 5, 2)->default(0);
            $table->decimal('commitment', 5, 2)->default(0);
            $table->decimal('discipline', 5, 2)->default(0);
            $table->decimal('cooperation', 5, 2)->default(0);
            $table->decimal('leadership', 5, 2)->nullable();
            
            // Administrative fields
            $table->text('recommendation')->nullable();
            $table->text('objection')->nullable();
            $table->text('response')->nullable();
            $table->text('decision')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('p2kps');
    }
};
