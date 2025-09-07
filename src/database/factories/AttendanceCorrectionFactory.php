<?php

namespace Database\Factories;

use App\Models\AttendanceCorrection;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceCorrectionFactory extends Factory
{
    protected $model = AttendanceCorrection::class;

    public function definition(): array
    {
        return [
            'requested_clock_in_at'   => null,
            'requested_break_start_at'=> null,
            'requested_break_end_at'  => null,
            'requested_clock_out_at'  => null,
            'requested_break_minutes' => null,
            'reason'                  => $this->faker->realText(40),
            'status'                  => 'pending',
            'reviewed_at'             => null,
            'review_comment'          => null,
        ];
    }
}
