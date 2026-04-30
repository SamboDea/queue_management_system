<div class="card h-100">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Counter Status</h5>
        <a href="{{ route('counters.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:11px">
            Manage
        </a>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            @foreach ($counters as $counter)
                @php
                    $badgeClass = match ($counter->status) {
                        'active' => 'bg-label-success',
                        'busy' => 'bg-label-warning',
                        'closed' => 'bg-label-secondary',
                        default => 'bg-label-secondary',
                    };
                @endphp
                <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-xs">
                            <span class="avatar-initial rounded {{ $badgeClass }}">
                                {{ strtoupper(substr($counter->code, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:500">{{ $counter->name }}</div>
                            @if ($counter->current_ticket)
                                <small class="text-muted" style="font-family:monospace">
                                    {{ $counter->current_ticket }}
                                </small>
                            @else
                                <small class="text-muted">No ticket</small>
                            @endif
                        </div>
                    </div>
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($counter->status) }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
