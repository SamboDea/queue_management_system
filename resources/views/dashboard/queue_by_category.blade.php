<div class="card h-100">
    <div class="card-header">
        <h5 class="mb-0">Category Today</h5>
    </div>
    <div class="card-body d-flex flex-column align-items-center justify-content-center">
        <canvas id="categoryChart" style="max-width:200px;max-height:200px"></canvas>
        <div class="mt-3 d-flex gap-3">
            <div class="text-center">
                <div class="fw-bold text-primary">{{ $queueByCategory['A'] ?? 0 }}</div>
                <small class="text-muted">General</small>
            </div>
            <div class="text-center">
                <div class="fw-bold text-warning">{{ $queueByCategory['B'] ?? 0 }}</div>
                <small class="text-muted">Finance</small>
            </div>
            <div class="text-center">
                <div class="fw-bold text-success">{{ $queueByCategory['C'] ?? 0 }}</div>
                <small class="text-muted">VIP</small>
            </div>
        </div>
    </div>
</div>
