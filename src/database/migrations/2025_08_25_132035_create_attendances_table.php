<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->restrictOnDelete();

            $table->date('work_date');

            $table->dateTime('clock_in_at')->nullable();
            $table->dateTime('clock_out_at')->nullable();

            $table->unsignedSmallInteger('break_minutes')->default(0);
            $table->unsignedInteger('total_work_minutes')->default(0);

            $table->string('note', 255)->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'work_date']);

        });

        Schema::table('attendances', function (Blueprint $t) {
            $t->unsignedInteger('work_minutes')
                ->default(0)
                ->after('clock_out_at');

            $t->unsignedTinyInteger('status')
                ->default(0)
                ->after('work_minutes');

            $t->unsignedTinyInteger('source')
                ->default(1)
                ->after('status');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
