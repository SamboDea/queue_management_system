<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Recent Queue</h5>
        <a href="{{ route('queue.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:11px">
            View All
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ticket</th>
                    <th>Category</th>
                    <th>Counter</th>
                    <th>Status</th>
                    <th>Called At</th>
                    <th>Wait</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentQueue as $q)
                    <tr>
                        <td>
                            <span class="fw-bold" style="font-family:monospace;font-size:14px">
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
                                $sClass = match ($q->status) {
                                    'waiting' => 'bg-label-warning',
                                    'serving' => 'bg-label-primary',
                                    'done' => 'bg-label-success',
                                    'skip' => 'bg-label-secondary',
                                    default => 'bg-label-secondary',
                                };
                            @endphp
                            <span class="badge {{ $sClass }}">{{ ucfirst($q->status) }}</span>
                        </td>
                        <td class="text-muted" style="font-size:12px">
                            {{ $q->called_at?->format('H:i:s') ?? '—' }}
                        </td>
                        <td class="text-muted" style="font-size:12px">
                            @if ($q->called_at)
                                {{ $q->created_at->diffInMinutes($q->called_at) }}m
                            @else
                                {{ $q->created_at->diffForHumans() }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No queue data today
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
