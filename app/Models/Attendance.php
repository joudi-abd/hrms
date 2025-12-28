<?php

namespace App\Models;

use App\Traits\ReportFilter;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use ReportFilter;
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'work_hours',
        'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected function getDateColumn()
    {
        return 'date';
    }


}
