<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Models\Features\Department;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::latest()->paginate(10);
            return view('feature.users.list_user', compact('users'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load users: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $departments = Department::where('status', 'active')->get();
            $roles = Role::all();
            return view('feature.users.create_user', compact('departments','roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load page: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'            => ['required', 'string', 'max:255'],
                'gender'          => ['required', 'in:male,female,other'],
                'email'           => ['required', 'email', 'unique:users,email'],
                'phone'           => ['nullable', 'string', 'max:20'],
                'department_code' => ['required', 'string', 'exists:departments,code'],
                'password'        => ['required', 'min:6'],
            ]);

            User::create([
                'name'            => $request->name,
                'gender'          => $request->gender,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'department_code' => $request->department_code,
                'password'        => Hash::make($request->password),
            ]);

            $user->assignRole($request->role); 

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        try {
            $departments = Department::where('status', 'active')->get();
            $roles = Role::all();
            
            return view('feature.users.show_user', compact('user','departments'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        try {
            $departments = Department::where('status', 'active')->get();
            $roles = Role::all();
            return view('feature.users.edit_user', compact('user','departments','roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name'            => ['required', 'string', 'max:255'],
                'gender'          => ['required', 'in:male,female,other'],
                'email'           => ['required', 'email', 'unique:users,email,' . $user->id],
                'phone'           => ['nullable', 'string', 'max:20'],
                'department_code' => ['required', 'string', 'exists:departments,code'],
                'password'        => ['nullable', 'min:8'],
            ]);

            $user->update([
                'name'            => $request->name,
                'gender'          => $request->gender,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'department_code' => $request->department_code,
                'password'        => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            $user->syncRoles($request->role);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}