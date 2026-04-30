<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Create Permissions ─────────────────────────────────────────────────
        $permissions = [

            // User
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Department
            'department.view',
            'department.create',
            'department.edit',
            'department.delete',

            // Role
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            // Counter
            'counter.view',
            'counter.create',
            'counter.edit',
            'counter.delete',

            // Queue
            'queue.view',
            'queue.create',
            'queue.edit',
            'queue.delete',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Super Admin — all permissions ──────────────────────────────────────
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(Permission::all());

        // ── Admin — all except delete role/user ───────────────────────────────
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'user.view',        'user.create',       'user.edit',
            'department.view',  'department.create',  'department.edit',  'department.delete',
            'role.view',
            'counter.view',     'counter.create',     'counter.edit',     'counter.delete',
            'queue.view',       'queue.create',        'queue.edit',       'queue.delete',
        ]);

        // ── Staff — daily operations only ─────────────────────────────────────
        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->syncPermissions([
            'user.view',
            'department.view',
            'counter.view',
            'queue.view',       'queue.create',       'queue.edit',
        ]);

        // ── Receptionist — queue & counter only ───────────────────────────────
        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->syncPermissions([
            'counter.view',
            'queue.view',       'queue.create',       'queue.edit',
        ]);

        // ── Viewer — read only ────────────────────────────────────────────────
        $viewer = Role::firstOrCreate(['name' => 'viewer']);
        $viewer->syncPermissions([
            'user.view',
            'department.view',
            'counter.view',
            'queue.view',
        ]);
    }
}