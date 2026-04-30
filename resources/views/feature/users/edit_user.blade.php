@extends('layouts.dashboard.main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit User</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="d-flex gap-4">
                    <div class="mb-3 w-100">
                        <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="John Doe" value="{{ old('name', $user->name) }}" />
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 w-100">
                        <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="" disabled>Select Gender</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                Female</option>
                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-4">
                    <div class="mb-3 w-100">
                        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" placeholder="john@example.com" value="{{ old('email', $user->email) }}" />
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 w-100">
                        <label class="form-label" for="phone">Phone No</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-phone"></i></span>
                            <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" placeholder="658 799 8941" value="{{ old('phone', $user->phone) }}" />
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-4">
                    <div class="mb-3 w-100">
                        <label class="form-label" for="department_code">Department <span
                                class="text-danger">*</span></label>
                        <select id="department_code" class="form-select @error('department_code') is-invalid @enderror"
                            name="department_code">
                            <option value="" disabled>Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->code }}"
                                    {{ old('department_code', $user->department_code) == $department->code ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 w-100">
                        <label class="form-label" for="password">Password <span class="text-danger text-sm">(leave blank
                                to keep current)</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-lock"></i></span>
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Enter new password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex gap-4">
                    <div class="mb-3 w-100">
                        <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
                        <select id="role" class="form-select @error('role') is-invalid @enderror" name="role">
                            <option value="" disabled>Select Role</option>
                            @foreach ($roles as $roleItem)
                                <option value="{{ $roleItem->name }}"
                                    {{ old('role', $user->getRoleNames()->first()) == $roleItem->name ? 'selected' : '' }}>
                                    {{ ucfirst($roleItem->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
