<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $date     = Carbon::today();
        $clockIn  = (clone $date)->setTime(9, 0);
        $clockOut = (clone $date)->setTime(18, 0);

        return [
            'user_id'       => User::factory(),
            'work_date'     => $date->toDateString(),
            'clock_in_at'   => $clockIn,
            'clock_out_at'  => $clockOut,
            'break_minutes' => 60,
            'note'          => null,
        ];
    }

    public function forDate(string $ymd): self
    {
        $date     = Carbon::parse($ymd);
        $clockIn  = (clone $date)->setTime(9, 0);
        $clockOut = (clone $date)->setTime(18, 0);

        return $this->state(fn () => [
            'work_date'     => $date->toDateString(),
            'clock_in_at'   => $clockIn,
            'clock_out_at'  => $clockOut,
            'break_minutes' => 60,
            'note'          => null,
        ]);
    }
}
