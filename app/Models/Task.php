<?php

namespace App\Models;

use App\Traits\ReportFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory , ReportFilter;
    protected $fillable = [
        'department_id',
        'title',
        'description',
        'status',
        'assigned_to',
        'created_by',
        'priority',
        'start_date',
        'due_date',
        'completed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    protected function getDateColumn()
    {
        return 'created_at';
    }
    protected function getEmployeeColumn()
    {
        return 'assigned_to';
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }


}
