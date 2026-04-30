@extends('layouts.dashboard.main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Create Role</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">Role Name <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-shield"></i></span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="e.g. admin" value="{{ old('name') }}" />
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Permissions <span class="text-danger">*</span></label>
                    @error('permissions')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror
                    @foreach ($permissions as $module => $modulePermissions)
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center gap-4 flex-wrap">
                                    <strong class="text-capitalize" style="min-width: 100px;">{{ $module }}</strong>
                                    @foreach ($modulePermissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                                {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }} />
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ explode('.', $permission->name)[1] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
