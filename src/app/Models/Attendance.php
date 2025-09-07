<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_date',
        'clock_in_at',
        'clock_out_at',
        'break_minutes',
        'note',
    ];

    protected $casts = [
        'work_date'   => 'date',
        'clock_in_at' => 'datetime',
        'clock_out_at'=> 'datetime',
        'break_minutes' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breaks()
    {
        return $this->hasMany(AttendanceBreak::class);
    }

    public function scopeOfUser($q, int $userId)
    {
        return $q->where('user_id', $userId);
    }

    public function scopeBetween($q, $from, $to)
    {
        return $q->whereBetween('work_date', [$from, $to]);
    }

    public function getWorkedMinutesAttribute(): ?int
    {
        if (!$this->clock_in_at || !$this->clock_out_at) return null;

        $in  = $this->clock_in_at;
        $out = $this->clock_out_at;

        $total = $out->diffInMinutes($in);
        $break = (int) ($this->break_minutes ?? 0);

        return max(0, $total - $break);
    }

    public function getOvertimeMinutesAttribute(): ?int
    {
        $worked = $this->worked_minutes;
        if ($worked === null) return null;

        return max(0, $worked - 480);
    }

    public function correction()
    {
        return $this->hasOne(AttendanceCorrection::class);
    }
}
