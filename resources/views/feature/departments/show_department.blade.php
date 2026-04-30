@extends('layouts.dashboard.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Department Detail</h5>
            <div>
                <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">
                    <i class="bx bx-edit me-1"></i> Edit
                </a>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Name</th>
                    <td>{{ $department->name }}</td>
                </tr>
                <tr>
                    <th>Code</th>
                    <td><span class="badge bg-label-primary">{{ $department->code }}</span></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $department->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($department->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $department->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
