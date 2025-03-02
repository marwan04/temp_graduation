<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::all();
        return view('instructor.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('instructor.roles.create');
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'RoleID' => 'required|integer|unique:Role,RoleID',
            'RoleName' => 'required|string|max:255',
        ]);

        Role::create($request->all());

        return redirect()->route('instructor.roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Show the form for editing a role.
     */
    public function edit(Role $role)
    {
        return view('instructor.roles.edit', compact('role'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'RoleName' => 'required|string|max:255',
        ]);

        $role->update($request->only('RoleName'));

        return redirect()->route('instructor.roles.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('instructor.roles.index')->with('success', 'Role deleted successfully!');
    }
}

