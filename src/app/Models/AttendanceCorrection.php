<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceCorrection extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id','applicant_id','reviewer_id',
        'requested_clock_in_at','requested_break_start_at','requested_break_end_at',
        'requested_clock_out_at','requested_break_minutes',
        'reason','status','reviewed_at','review_comment',
    ];

    protected $casts = [
        'requested_clock_in_at'    => 'datetime',
        'requested_break_start_at' => 'datetime',
        'requested_break_end_at'   => 'datetime',
        'requested_clock_out_at'   => 'datetime',
        'requested_break_minutes'  => 'integer',
        'reviewed_at'              => 'datetime',
    ];

    public function attendance() { return $this->belongsTo(Attendance::class); }
    public function applicant()  { return $this->belongsTo(User::class, 'applicant_id'); }
    public function reviewer()   { return $this->belongsTo(User::class, 'reviewer_id'); }
}
