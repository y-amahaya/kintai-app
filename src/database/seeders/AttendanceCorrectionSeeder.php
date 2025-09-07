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
        $all = Attendance::query()->with('user:id,role')->get();

        if ($all->isEmpty()) {
            return;
        }

        $adminId = User::where('role', User::ROLE_ADMIN)->value('id');

        $targetCount = (int) floor($all->count() * 0.10);
        $targets = $all->random($targetCount);

        foreach ($targets as $attendance) {
            $applicantId = $attendance->user_id;

            $rand = mt_rand(1, 100);
            if ($rand <= 70) {
                $status = 'approved';
            } elseif ($rand <= 90) {
                $status = 'pending';
            } else {
                $status = 'rejected';
            }

            $reviewedAt = in_array($status, ['approved', 'rejected'], true)
                ? Carbon::parse($attendance->work_date)->addDay()->setTime(10, 0, 0)
                : null;

            $reviewerId = $reviewedAt ? $adminId : null;

            $requestedClockOut = Carbon::parse($attendance->clock_out_at)->addMinutes(10);

            AttendanceCorrection::updateOrCreate(
                ['attendance_id' => $attendance->id],
                [
                    'applicant_id'              => $applicantId,
                    'reviewer_id'               => $reviewerId,
                    'requested_clock_in_at'     => null,
                    'requested_break_start_at'  => null,
                    'requested_break_end_at'    => null,
                    'requested_clock_out_at'    => $requestedClockOut,
                    'requested_break_minutes'   => null,
                    'reason'                    => '退勤時刻の修正申請',
                    'status'                    => $status,
                    'reviewed_at'               => $reviewedAt,
                    'review_comment'            => $reviewedAt ? '確認済み' : null,
                ]
            );
        }
    }
}
