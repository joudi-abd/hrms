<?php
namespace App\Concerns;

use App\Models\Role;

trait HasRoles
{
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function hasAbility($ability){
        return $this->roles()->whereHas('abilities', function($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', 'allow');
        })->exists();
    }
}