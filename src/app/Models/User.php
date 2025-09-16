<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 90;
    public const ROLE_EMPLOYEE  = 10;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'department_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'role'              => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function overtimeRequests()
    {
        return $this->hasMany(OvertimeRequest::class);
    }

    public function approvedLeaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'approver_id');
    }

    public function approvedOvertimeRequests()
    {
        return $this->hasMany(OvertimeRequest::class, 'approver_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function scopeAdmins($q)
    {
        return $q->where('role', self::ROLE_ADMIN);
    }

    public function scopeUsers($q)
    {
        return $q->where('role', self::ROLE_EMPLOYEE);
    }

    public function submittedCorrections()
    {
        return $this->hasMany(AttendanceCorrection::class, 'applicant_id');
    }

    public function reviewCorrections()
    {
        return $this->hasMany(AttendanceCorrection::class, 'reviewer_id');
    }
}
