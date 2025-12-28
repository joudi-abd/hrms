<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'employee_id',
        'first_name',       
        'last_name',
        'birth_date',
        'phone',
        'address',
        'gender',
        'marital_status',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
