<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'max_days_per_year',
        'is_paid'
    ];

    public function leaves()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
