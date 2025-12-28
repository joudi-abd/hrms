<?php

namespace App\Models;

use App\Concerns\HasRoles;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;


class Employee extends Authenticatable
{
    use HasFactory, Notifiable , TwoFactorAuthenticatable , HasRoles;

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'password',
        'department_id',
        'direct_manager_id',
        'status',   
        'job_title',
        'hire_date',
        'salary',
        'super_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class)->withDefault(['first_name' =>'']);
    }
    public function departmentHeaded()
    {
        return $this->hasOne(Department::class, 'head_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class , 'department_id');
    }
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'direct_manager_id');
    }
    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'direct_manager_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class , 'employee_id');
    }
    public function leaves()
    {
        return $this->hasMany(LeaveRequest::class , 'employee_id');
    }
    public function approvedLeaves()
    {
        return $this->hasMany(LeaveRequest::class , 'approved_by');
    }
    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function getFullNameAttribute()
    {
        return $this->profile->first_name . ' ' . $this->profile->last_name;
    }
    
}
