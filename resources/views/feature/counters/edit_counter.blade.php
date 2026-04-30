@extends('layouts.dashboard.main')

@section('content')
    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bx-edit me-2 text-primary"></i>Edit Counter
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 13px">
                    <li class="breadcrumb-item">
                        <a href="{{ route('counters.index') }}" class="text-muted">Counters</a>
                    </li>
                    <li class="breadcrumb-item active">Edit — {{ $counter->name }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('counters.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i> Back
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            {{-- Edit Form --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Counter Information</h5>
                    @php
                        $badgeClass = match ($counter->status) {
                            'active' => 'bg-label-success',
                            'busy' => 'bg-label-warning',
                            'closed' => 'bg-label-secondary',
                            default => 'bg-label-secondary',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}" id="headerBadge">
                        {{ ucfirst($counter->status) }}
                    </span>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('counters.update', $counter) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                Counter Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $counter->name) }}" placeholder="e.g. Counter 1" autofocus />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Code --}}
                        <div class="mb-4">
                            <label for="code" class="form-label">
                                Counter Code <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bx bx-hash"></i>
                                </span>
                                <input type="text" id="code" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $counter->code) }}" placeholder="e.g. C1" maxlength="10"
                                    oninput="this.value = this.value.toUpperCase()" />
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Short unique identifier, auto uppercase. Max 10 characters.</div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active"
                                    {{ old('status', $counter->status) === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="busy" {{ old('status', $counter->status) === 'busy' ? 'selected' : '' }}>
                                    Busy
                                </option>
                                <option value="closed"
                                    {{ old('status', $counter->status) === 'closed' ? 'selected' : '' }}>
                                    Closed
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Current ticket (readonly info) --}}
                        @if ($counter->current_ticket)
                            <div class="mb-4">
                                <label class="form-label">Current Ticket</label>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-label-info" style="font-family: monospace; font-size: 14px">
                                        <i class="bx bx-receipt me-1"></i>{{ $counter->current_ticket }}
                                    </span>
                                    <small class="text-muted">This counter is currently serving this ticket</small>
                                </div>
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="d-flex gap-2 pt-3 mt-2 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Update Counter
                            </button>
                            <a href="{{ route('counters.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="card border border-danger">
                <div class="card-header border-bottom border-danger">
                    <h5 class="mb-0 text-danger">
                        <i class="bx bx-error-circle me-1"></i> Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <p class="fw-semibold mb-1" style="font-size: 14px">
                                Delete "{{ $counter->name }}"
                            </p>
                            <p class="text-muted mb-0" style="font-size: 12px">
                                Permanently delete this counter. This action cannot be undone
                                and will affect all related queue records.
                            </p>
                        </div>
                        <form action="{{ route('counters.destroy', $counter) }}" method="POST"
                            onsubmit="return confirm('Delete \'{{ $counter->name }}\'?\nThis cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm flex-shrink-0">
                                <i class="bx bx-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>

    <script>
        // Live status badge update in card header
        const statusSelect = document.getElementById('status');
        const headerBadge = document.getElementById('headerBadge');

        const badgeMap = {
            active: {
                class: 'bg-label-success',
                label: 'Active'
            },
            busy: {
                class: 'bg-label-warning',
                label: 'Busy'
            },
            closed: {
                class: 'bg-label-secondary',
                label: 'Closed'
            },
        };

        statusSelect.addEventListener('change', function() {
            const val = this.value;
            if (badgeMap[val]) {
                headerBadge.className = 'badge ' + badgeMap[val].class;
                headerBadge.textContent = badgeMap[val].label;
            }
        });
    </script>
@endsection
