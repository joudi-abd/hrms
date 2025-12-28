<?php

namespace App\Models;

use App\Http\Requests\RoleRequest;
use Illuminate\Database\Eloquent\Model;
use Request;

class Role extends Model
{
    protected $fillable = ['name'];

    public function abilities()
    {
        return $this->hasMany(RoleAbility::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'role_user');
    }
    public static function createWithAbilities($request){
        $role = Role::create(['name' => $request['name']]);
        foreach($request['abilities'] as $ability=> $value){
            RoleAbility::create([
                'role_id' => $role->id,
                'ability' => $ability,
                'type' => $value
            ]);
        }
        return $role;
    }

    public function updateWithAbilities($request){
        $this->update(['name' => $request['name']]);
        foreach($request['abilities'] as $ability=> $value){
            RoleAbility::updateOrCreate(
                [
                    'role_id' => $this->id,
                    'ability' => $ability
                ],
                [
                    'type' => $value
                ]
            );
        }
        return $this;
    }
}
