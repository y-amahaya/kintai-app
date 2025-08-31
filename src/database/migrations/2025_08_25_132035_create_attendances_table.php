<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->restrictOnDelete();

            $table->date('work_date');

            $table->dateTime('clock_in_at')->nullable();
            $table->dateTime('break_start_at')->nullable();
            $table->dateTime('break_end_at')->nullable();
            $table->dateTime('clock_out_at')->nullable();

            $table->unsignedSmallInteger('break_minutes')->default(0);
            $table->unsignedInteger('total_work_minutes')->default(0);

            $table->string('note', 255)->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'work_date']);

            $table->index(['user_id', 'work_date']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
