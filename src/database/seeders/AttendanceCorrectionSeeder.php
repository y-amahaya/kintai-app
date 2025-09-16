<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use App\Models\User;
use Carbon\Carbon;

class AttendanceCorrectionSeeder extends Seeder
{
    public function run(): void
    {
        $attendances = Attendance::query()->with('user:id,role')->get();
        if ($attendances->isEmpty()) {
            return;
        }

        $adminId = User::where('role', User::ROLE_ADMIN)->value('id');

        $targetCount = (int) floor($attendances->count() * 0.10);
        if ($targetCount === 0) {
            return;
        }
        $targets = $attendances->shuffle()->take($targetCount);

        foreach ($targets as $attendance) {
            $applicantId = $attendance->user_id;

            $r = mt_rand(1, 100);
            $status = ($r <= 70) ? 1 : (($r <= 90) ? 0 : 2);

            if (empty($attendance->clock_out_at)) {
                continue;
            }
            $requestedClockOut = Carbon::parse($attendance->clock_out_at)->addMinutes(10);

            AttendanceCorrection::updateOrCreate(
                ['attendance_id' => $attendance->id],
                [
                    'applicant_id'           => $applicantId,
                    'reviewer_id'            => $adminId ?: null,
                    'requested_clock_in_at'  => null,
                    'requested_clock_out_at' => $requestedClockOut,
                    'reason'                 => '退勤時刻の修正申請',
                    'status'                 => $status,
                ]
            );
        }
    }
}
