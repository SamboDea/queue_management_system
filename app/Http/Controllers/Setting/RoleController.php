<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::with('permissions')->latest()->paginate(10);
            return view('feature.setting.roles.list_role', compact('roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load roles: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $permissions = Permission::all()->groupBy(function ($permission) {
                return explode('.', $permission->name)[0]; // group by module
            });
            return view('feature.setting.roles.create_role', compact('permissions'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load page: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'        => ['required', 'string', 'max:255', 'unique:roles,name'],
                'permissions' => ['required', 'array'],
            ]);

            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            return redirect()->route('feature.setting.roles.list_role')->with('success', 'Role created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        try {
            $permissions = Permission::all()->groupBy(function ($permission) {
                return explode('.', $permission->name)[0];
            });
            $rolePermissions = $role->permissions->pluck('name')->toArray();
            return view('feature.setting.roles.edit_role', compact('role', 'permissions', 'rolePermissions'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load role: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name'        => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
                'permissions' => ['required', 'array'],
            ]);

            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            return redirect()->route('feature.setting.roles.list_role')->with('success', 'Role updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('feature.setting.roles.list_role')->with('success', 'Role deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }
}