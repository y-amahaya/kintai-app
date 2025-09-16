<?php

namespace Database\Factories;

use App\Models\AttendanceCorrection;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceCorrectionFactory extends Factory
{
    protected $model = AttendanceCorrection::class;

    public function definition(): array
    {
        return [
            'attendance_id'            => Attendance::factory(),
            'applicant_id'             => User::factory(),
            'reviewer_id'              => null,
            'requested_clock_in_at'    => null,
            'requested_clock_out_at'   => null,
            'reason'                   => $this->faker->realText(40),
        ];
    }
}
