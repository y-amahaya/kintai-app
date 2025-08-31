<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'date';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'date',
        'name',
        'is_company_holiday',
    ];

    protected $casts = [
        'date'               => 'date',
        'is_company_holiday' => 'boolean',
    ];

    public function scopeCompany($q)
    {
        return $q->where('is_company_holiday', true);
    }

    public function scopeOfMonth($q, string $yearMonth)
    {
        return $q->where('date', 'like', $yearMonth . '%');
    }
}
