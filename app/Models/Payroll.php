<?php

namespace App\Models;

use App\Concerns\HasRoles;
use App\Traits\ReportFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory , HasRoles , ReportFilter;
    protected $fillable = [
        'employee_id',
        'payroll_month',
        'paid_leaves',
        'unpaid_leaves',
        'gross_salary',
        'deductions',
        'bonuses',
        'net_salary',
        'date_paid',
    ];

    protected $casts = [
        'payroll_month' => 'date',
        'date_paid' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopePaid($query)
    {
        return $query->whereNotNull('date_paid');
    }
    public function scopeUnpaid($query)
    {
        return $query->whereNull('date_paid');
    }

    public function scopeForMonth($query, $month)
    {
        $date = Carbon::parse($month);
        return $query->whereYear('payroll_month', $date->year)
        ->whereMonth('payroll_month', $date->month);
    }

    protected function getDateColumn()
    {
        return 'payroll_month';
    }

    protected function applyStatusFilter($query, string $status): void
    {
        if ($status === 'paid') {
            $query->paid();
        } elseif ($status === 'unpaid') {
            $query->unpaid();
        }
    }
    
}
