@extends('layouts.dashboard.main')

@section('content')
    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bx-plus-circle me-2 text-primary"></i>Add Counter
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 13px">
                    <li class="breadcrumb-item">
                        <a href="{{ route('counters.index') }}" class="text-muted">Counters</a>
                    </li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('counters.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i> Back
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Counter Information</h5>
                </div>
                <div class="card-body pt-4">
                    <form action="{{ route('counters.store') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                Counter Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="e.g. Counter 1" autofocus />
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
                                    class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}"
                                    placeholder="e.g. C1" maxlength="10" oninput="this.value = this.value.toUpperCase()" />
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
                                <option value="">— Select status —</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="busy" {{ old('status') === 'busy' ? 'selected' : '' }}>
                                    Busy
                                </option>
                                <option value="closed" {{ old('status', 'closed') === 'closed' ? 'selected' : '' }}>
                                    Closed
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Status preview badge --}}
                            <div class="mt-2" id="statusPreview" style="display: none">
                                <small class="text-muted me-1">Preview:</small>
                                <span class="badge" id="statusBadge"></span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2 pt-3 mt-2 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Save Counter
                            </button>
                            <a href="{{ route('counters.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script>
        // Status badge live preview
        const statusSelect = document.getElementById('status');
        const statusPreview = document.getElementById('statusPreview');
        const statusBadge = document.getElementById('statusBadge');

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
            if (val && badgeMap[val]) {
                statusBadge.className = 'badge ' + badgeMap[val].class;
                statusBadge.textContent = badgeMap[val].label;
                statusPreview.style.display = 'block';
            } else {
                statusPreview.style.display = 'none';
            }
        });

        // Trigger on load if old() value exists
        if (statusSelect.value) statusSelect.dispatchEvent(new Event('change'));
    </script>
@endsection
