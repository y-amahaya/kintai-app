<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_correction_breaks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attendance_correction_id')
                ->constrained('attendance_corrections')->cascadeOnDelete();

            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedSmallInteger('minutes');

            $table->timestamps();

            $table->index(
                ['attendance_correction_id', 'start_at'],
                'acb_accid_start_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_correction_breaks');
    }
};
