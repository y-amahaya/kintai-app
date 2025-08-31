<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_corrections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attendance_id')
                ->constrained('attendances')->cascadeOnDelete();

            $table->foreignId('applicant_id')
                ->constrained('users')->restrictOnDelete();

            $table->foreignId('reviewer_id')
                ->nullable()->constrained('users')->nullOnDelete();

            $table->dateTime('requested_clock_in_at')->nullable();
            $table->dateTime('requested_break_start_at')->nullable();
            $table->dateTime('requested_break_end_at')->nullable();
            $table->dateTime('requested_clock_out_at')->nullable();
            $table->unsignedSmallInteger('requested_break_minutes')->nullable();

            $table->text('reason');
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->dateTime('reviewed_at')->nullable();
            $table->text('review_comment')->nullable();

            $table->timestamps();

            $table->index('attendance_id');
            $table->index(['applicant_id', 'status']);
            $table->index(['status', 'reviewed_at']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_corrections');
    }
};
