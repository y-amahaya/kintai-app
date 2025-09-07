<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $date = Carbon::today()->toDateString();
        $clockIn   = Carbon::parse("$date 09:00:00");
        $breakSt   = Carbon::parse("$date 12:00:00");
        $breakEnd  = Carbon::parse("$date 13:00:00");
        $clockOut  = Carbon::parse("$date 18:00:00");

        $breakMinutes  = 60;
        $totalWorkMins = $clockOut->diffInMinutes($clockIn) - $breakMinutes;

        return [
            'work_date'          => $date,
            'clock_in_at'        => $clockIn,
            'break_start_at'     => $breakSt,
            'break_end_at'       => $breakEnd,
            'clock_out_at'       => $clockOut,
            'break_minutes'      => $breakMinutes,
            'total_work_minutes' => $totalWorkMins,
            'note'               => null,
        ];
    }

    public function forDate(string $ymd): self
    {
        $clockIn  = Carbon::parse("$ymd 09:00:00");
        $breakSt  = Carbon::parse("$ymd 12:00:00");
        $breakEnd = Carbon::parse("$ymd 13:00:00");
        $clockOut = Carbon::parse("$ymd 18:00:00");

        $break = 60;
        $total = $clockOut->diffInMinutes($clockIn) - $break;

        return $this->state(fn () => [
            'work_date'          => $ymd,
            'clock_in_at'        => $clockIn,
            'break_start_at'     => $breakSt,
            'break_end_at'       => $breakEnd,
            'clock_out_at'       => $clockOut,
            'break_minutes'      => $break,
            'total_work_minutes' => $total,
            'note'               => null,
        ]);
    }
}
