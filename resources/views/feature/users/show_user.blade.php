@extends('layouts.dashboard.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User Detail</h5>
            <div>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                    <i class="bx bx-edit me-1"></i> Edit
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Full Name</th>
                    <td>{{ $user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ ucfirst($user->gender) ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $user->department->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    {{-- <td>{{ $user->created_at->format('d M Y, h:i A') }}</td> --}}
                </tr>
            </table>
        </div>
    </div>
@endsection
