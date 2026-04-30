@extends('layouts.dashboard.main')

@section('content')
    {{-- Page header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Queue Management</h4>
            <p class="text-muted mb-0" style="font-size:13px">Today — {{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('queue.display') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-desktop me-1"></i> Display Screen
            </a>

            {{-- Take ticket form --}}
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bx bx-plus me-1"></i> Take Ticket
                </button>
                <div class="dropdown-menu p-3" style="min-width:200px">
                    <p class="text-muted mb-2" style="font-size:12px">Select category:</p>
                    <form action="{{ route('queue.take') }}" method="POST">
                        @csrf
                        <div class="d-flex gap-2">
                            <button name="category" value="A"
                                class="btn btn-sm btn-outline-primary flex-fill">A</button>
                            <button name="category" value="B"
                                class="btn btn-sm btn-outline-warning flex-fill">B</button>
                            <button name="category" value="C"
                                class="btn btn-sm btn-outline-success flex-fill">C</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Stats row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h3 class="mb-0 fw-bold text-warning">{{ $waiting }}</h3>
                    <small class="text-muted">Waiting</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h3 class="mb-0 fw-bold text-primary">{{ $serving }}</h3>
                    <small class="text-muted">Serving</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h3 class="mb-0 fw-bold text-success">{{ $done }}</h3>
                    <small class="text-muted">Done today</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h3 class="mb-0 fw-bold text-info">{{ $counters->count() }}</h3>
                    <small class="text-muted">Counters</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── Counter control ── --}}
        <div class="col-12 col-lg-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Counters</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach ($counters as $counter)
                            <li class="list-group-item d-flex align-items-center justify-content-between py-3 px-4">
                                <div>
                                    <div class="fw-semibold" style="font-size:14px">{{ $counter->name }}</div>
                                    <small class="text-muted">
                                        {{ $counter->current_ticket ?? 'No ticket' }}
                                    </small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    {{-- Status badge --}}
                                    @php
                                        $badgeClass = match ($counter->status) {
                                            'active' => 'bg-label-primary',
                                            'busy' => 'bg-label-warning',
                                            default => 'bg-label-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($counter->status) }}</span>

                                    {{-- Call next --}}
                                    @if ($counter->status !== 'closed')
                                        <form action="{{ route('queue.call-next') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="counter_id" value="{{ $counter->id }}">
                                            <button class="btn btn-sm btn-primary" title="Call next">
                                                <i class="bx bx-chevron-right"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Toggle open/close --}}
                                    <form action="{{ route('queue.counter.toggle', $counter) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button
                                            class="btn btn-sm {{ $counter->status === 'closed' ? 'btn-outline-success' : 'btn-outline-secondary' }}"
                                            title="{{ $counter->status === 'closed' ? 'Open' : 'Close' }}">
                                            <i
                                                class="bx {{ $counter->status === 'closed' ? 'bx-power-off' : 'bx-x' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- ── Queue table ── --}}
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Today's Queue</h5>
                    <small class="text-muted">{{ now()->format('d M Y') }}</small>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Ticket</th>
                                <th>Category</th>
                                <th>Counter</th>
                                <th>Status</th>
                                <th>Called at</th>
                                <th>Wait</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($queues as $q)
                                <tr>
                                    <td class="text-muted" style="font-size:12px">{{ $q->id }}</td>
                                    <td>
                                        <span class="fw-bold" style="font-family:monospace;font-size:15px">
                                            {{ $q->ticket_number }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $catClass = match ($q->category) {
                                                'A' => 'bg-label-primary',
                                                'B' => 'bg-label-warning',
                                                'C' => 'bg-label-success',
                                                default => 'bg-label-secondary',
                                            };
                                            $catLabel = match ($q->category) {
                                                'A' => 'General',
                                                'B' => 'Finance',
                                                'C' => 'VIP',
                                                default => $q->category,
                                            };
                                        @endphp
                                        <span class="badge {{ $catClass }}">{{ $catLabel }}</span>
                                    </td>
                                    <td class="text-muted" style="font-size:13px">
                                        {{ optional($q->counter)->name ?? '—' }}
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match ($q->status) {
                                                'waiting' => 'bg-label-warning',
                                                'serving' => 'bg-label-primary',
                                                'done' => 'bg-label-success',
                                                'skip' => 'bg-label-secondary',
                                                default => 'bg-label-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($q->status) }}</span>
                                    </td>
                                    <td class="text-muted" style="font-size:12px">
                                        {{ $q->called_at?->format('H:i:s') ?? '—' }}
                                    </td>
                                    <td class="text-muted" style="font-size:12px">
                                        @if ($q->called_at)
                                            {{ $q->created_at->diffInMinutes($q->called_at) }}m
                                        @else
                                            {{ $q->created_at->diffForHumans(short: true) }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if ($q->status === 'serving')
                                                <form action="{{ route('queue.done', $q) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-sm btn-success" title="Mark done">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if (in_array($q->status, ['waiting', 'serving']))
                                                <form action="{{ route('queue.skip', $q) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-sm btn-outline-secondary" title="Skip">
                                                        <i class="bx bx-skip-next"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bx bx-inbox" style="font-size:32px;display:block;margin-bottom:8px"></i>
                                        No tickets today
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($queues->hasPages())
                    <div class="card-footer">
                        {{ $queues->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
    </div>

    <script>
        // Auto-dismiss alerts
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(() => new bootstrap.Alert(el).close(), 500);
            }, 4000);
        });

        // Auto-refresh page every 10s to reflect queue changes
        // setTimeout(() => location.reload(), 10000);
    </script>
@endsection
