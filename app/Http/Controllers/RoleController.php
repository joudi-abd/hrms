<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        $roles = Role::paginate(10);
        
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);
        $role = Role::createWithAbilities($request->validated());
        return redirect()->route('roles.index')->with('success', __('Created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $this->authorize('view', Role::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $role_abilities = $role->abilities()->pluck('type', 'ability')->toArray();
        return view('roles.edit', compact('role', 'role_abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $role->updateWithAbilities( $request->validated());
        return redirect()->route('roles.index')->with('update', __('Updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        if ($role->employees()->exists()) {
            return redirect()->route('roles.index')->with('error', __('Role cannot be deleted because it is assigned to one or more employees.'));
        }
        $role->delete();
        return redirect()->route('roles.index')->with('delete', __('Deleted successfully.'));
    }
}
