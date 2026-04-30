@extends('layouts.dashboard.main')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bxs-discount me-2 text-primary"></i>Counter List
            </h4>
            <p class="text-muted mb-0" style="font-size: 13px">
                Manage all service counters
            </p>
        </div>
        <a href="{{ route('counters.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Add Counter
        </a>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bx bx-x-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-list-ul"></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $counters->total() }}</h5>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-circle"></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-success">
                            {{ $counters->getCollection()->where('status', 'active')->count() }}</h5>
                        <small class="text-muted">Active</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-time"></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-warning">
                            {{ $counters->getCollection()->where('status', 'busy')->count() }}</h5>
                        <small class="text-muted">Busy</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-secondary">
                            <i class="bx bx-x-circle"></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-secondary">
                            {{ $counters->getCollection()->where('status', 'closed')->count() }}</h5>
                        <small class="text-muted">Closed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="mb-0">All Counters</h5>

            {{-- Search --}}
            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm" style="width: 220px">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search counter..." />
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="counterTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Counter</th>
                        <th>Code</th>
                        <th>Current Ticket</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th style="width: 110px" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($counters as $index => $counter)
                        <tr>
                            {{-- No --}}
                            <td class="text-muted" style="font-size: 12px">
                                {{ $counters->firstItem() + $index }}
                            </td>

                            {{-- Name --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-sm flex-shrink-0">
                                        @php
                                            $avatarColor = match ($counter->status) {
                                                'active' => 'bg-label-primary',
                                                'busy' => 'bg-label-warning',
                                                'closed' => 'bg-label-secondary',
                                                default => 'bg-label-primary',
                                            };
                                        @endphp
                                        <span class="avatar-initial rounded-circle {{ $avatarColor }}">
                                            {{ strtoupper(substr($counter->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="fw-semibold d-block" style="font-size: 14px">
                                            {{ $counter->name }}
                                        </span>
                                        <small class="text-muted">ID: {{ $counter->id }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Code --}}
                            <td>
                                <span class="badge bg-label-dark"
                                    style="font-family: monospace; font-size: 12px; letter-spacing: 0.05em">
                                    {{ $counter->code }}
                                </span>
                            </td>

                            {{-- Current Ticket --}}
                            <td>
                                @if ($counter->current_ticket)
                                    <span class="badge bg-label-info" style="font-family: monospace; font-size: 13px">
                                        <i class="bx bx-receipt me-1"></i>{{ $counter->current_ticket }}
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size: 13px">—</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @php
                                    $statusConfig = match ($counter->status) {
                                        'active' => [
                                            'class' => 'bg-label-success',
                                            'icon' => 'bx-radio-circle-marked',
                                            'label' => 'Active',
                                        ],
                                        'busy' => [
                                            'class' => 'bg-label-warning',
                                            'icon' => 'bx-time-five',
                                            'label' => 'Busy',
                                        ],
                                        'closed' => [
                                            'class' => 'bg-label-secondary',
                                            'icon' => 'bx-minus-circle',
                                            'label' => 'Closed',
                                        ],
                                        default => [
                                            'class' => 'bg-label-secondary',
                                            'icon' => 'bx-circle',
                                            'label' => ucfirst($counter->status),
                                        ],
                                    };
                                @endphp
                                <span class="badge {{ $statusConfig['class'] }}">
                                    <i class="bx {{ $statusConfig['icon'] }} me-1"></i>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>

                            {{-- Created At --}}
                            <td>
                                <span style="font-size: 13px">
                                    {{ $counter->created_at?->format('d M Y') ?? '—' }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ $counter->created_at?->format('H:i') ?? '' }}
                                </small>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- Edit --}}
                                    <a href="{{ route('counters.edit', $counter) }}"
                                        class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="tooltip"
                                        title="Edit">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger"
                                        data-bs-toggle="tooltip" title="Delete"
                                        onclick="confirmDelete({{ $counter->id }}, '{{ $counter->name }}')">
                                        <i class="bx bx-trash"></i>
                                    </button>

                                    {{-- Hidden delete form --}}
                                    <form id="delete-form-{{ $counter->id }}"
                                        action="{{ route('counters.destroy', $counter) }}" method="POST"
                                        class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bx bx-inbox d-block mb-2" style="font-size: 48px; color: #ccc"></i>
                                <p class="text-muted mb-3">No counters found</p>
                                <a href="{{ route('counters.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bx bx-plus me-1"></i> Add First Counter
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($counters->hasPages())
            <div class="card-footer d-flex align-items-center justify-content-between flex-wrap gap-2">
                <small class="text-muted">
                    Showing {{ $counters->firstItem() }}–{{ $counters->lastItem() }} of {{ $counters->total() }}
                    counters
                </small>
                {{ $counters->links() }}
            </div>
        @endif
    </div>

    <script>
        // ── Tooltips ──────────────────────────────────────────────────────────────
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el, {
                trigger: 'hover'
            });
        });

        // ── Delete confirmation ───────────────────────────────────────────────────
        function confirmDelete(id, name) {
            if (confirm(`Delete "${name}"?\nThis action cannot be undone.`)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // ── Live search ───────────────────────────────────────────────────────────
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('#counterTable tbody tr').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });

        // ── Auto-dismiss alerts ───────────────────────────────────────────────────
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-6px)';
                setTimeout(() => new bootstrap.Alert(el).close(), 600);
            }, 5000);
        });
    </script>
@endsection
