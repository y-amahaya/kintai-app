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

        DB::statement("
            INSERT INTO attendance_breaks (attendance_id, start_at, end_at, minutes, created_at, updated_at)
            SELECT id, break_start_at, break_end_at,
                GREATEST(0, TIMESTAMPDIFF(MINUTE, break_start_at, break_end_at)),
                NOW(), NOW()
            FROM attendances
            WHERE break_start_at IS NOT NULL AND break_end_at IS NOT NULL
        ");

        DB::statement("
            UPDATE attendances a
            LEFT JOIN (
            SELECT attendance_id, COALESCE(SUM(minutes),0) AS sum_break
            FROM attendance_breaks
            GROUP BY attendance_id
            ) b ON b.attendance_id = a.id
            SET a.break_minutes = COALESCE(b.sum_break, 0)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_breaks');
    }
};
