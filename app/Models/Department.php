<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, Translatable;
    protected $fillable = [
        'name',
        'head_id',
        'description',
        'status',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function head()
    {
        return $this->belongsTo(Employee::class, 'head_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getTranslatableAttributes():array{
        return ['name', 'description'];
    }
}
