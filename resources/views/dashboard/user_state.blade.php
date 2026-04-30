<div class="card mb-3">
    <div class="card-body">
        <h6 class="mb-3">User Registration</h6>
        <div class="d-flex justify-content-between mb-3">
            <div class="text-center">
                <h5 class="fw-bold mb-0 text-primary">{{ $newUsersToday }}</h5>
                <small class="text-muted">Today</small>
            </div>
            <div class="text-center">
                <h5 class="fw-bold mb-0 text-info">{{ $newUsersWeek }}</h5>
                <small class="text-muted">This Week</small>
            </div>
            <div class="text-center">
                <h5 class="fw-bold mb-0 text-success">{{ $newUsersMonth }}</h5>
                <small class="text-muted">This Month</small>
            </div>
        </div>
        <canvas id="genderChart" height="140"></canvas>
    </div>
</div>
