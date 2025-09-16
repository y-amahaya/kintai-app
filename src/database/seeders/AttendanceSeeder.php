<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $start = Carbon::create(2025, 9, 1)->startOfDay();
        $end   = Carbon::create(2025, 9, 30)->endOfDay();

        $employees = User::where('role', User::ROLE_EMPLOYEE)->pluck('id');

        foreach ($employees as $userId) {
            $date = $start->copy();
            while ($date->lte($end)) {
                $workDate = $date->toDateString();

                $clockIn  = Carbon::parse("$workDate 09:00:00");
                $breakSt  = Carbon::parse("$workDate 12:00:00");
                $breakEnd = Carbon::parse("$workDate 13:00:00");
                $clockOut = Carbon::parse("$workDate 18:00:00");

                $breakMins  = 60;
                $totalMins  = $clockOut->diffInMinutes($clockIn, true) - $breakMins;

                Attendance::updateOrCreate(
                    ['user_id' => $userId, 'work_date' => $workDate],
                    [
                        'clock_in_at'        => $clockIn,
                        'clock_out_at'       => $clockOut,
                        'break_minutes'      => $breakMins,
                        'total_work_minutes' => $totalMins,
                        'note'               => null,
                    ]
                );

                $date->addDay();
            }
        }
    }
}
