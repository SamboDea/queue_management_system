<div class="card h-100">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-primary">
                    <i class="bx bx-group"></i>
                </span>
            </div>
            <span class="badge bg-label-success" style="font-size:10px">
                +{{ $newUsersToday }} today
            </span>
        </div>
        <h4 class="fw-bold mb-0">{{ number_format($totalUsers) }}</h4>
        <small class="text-muted">Total Users</small>
        <div class="mt-2" style="font-size:11px;color:#aaa">
            <i class="bx bx-trending-up text-success"></i> {{ $newUsersWeek }} this week
        </div>
    </div>
</div>
