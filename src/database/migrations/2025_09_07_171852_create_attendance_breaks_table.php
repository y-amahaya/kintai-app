<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_breaks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attendance_id')
                ->constrained('attendances')->cascadeOnDelete();

            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedSmallInteger('minutes');

            $table->timestamps();

            $table->index(['attendance_id', 'start_at']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_breaks');
    }
};
