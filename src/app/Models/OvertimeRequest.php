<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OvertimeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_date',
        'minutes',
        'status',
        'approver_id',
        'reason',
    ];

    protected $casts = [
        'target_date' => 'date',
        'minutes'     => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function scopeOfUser($q, int $userId)
    {
        return $q->where('user_id', $userId);
    }
}
