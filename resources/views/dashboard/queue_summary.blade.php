<div class="card">
    <div class="card-body">
        <h6 class="mb-3">Today's Queue Summary</h6>
        <div class="row g-2 text-center">
            <div class="col-6">
                <div class="p-2 rounded bg-label-info">
                    <h5 class="fw-bold mb-0">{{ $queueToday }}</h5>
                    <small class="text-muted">Total</small>
                </div>
            </div>
            <div class="col-6">
                <div class="p-2 rounded bg-label-success">
                    <h5 class="fw-bold mb-0">{{ $servedToday }}</h5>
                    <small class="text-muted">Served</small>
                </div>
            </div>
            <div class="col-6">
                <div class="p-2 rounded bg-label-warning">
                    <h5 class="fw-bold mb-0">{{ $waitingNow }}</h5>
                    <small class="text-muted">Waiting</small>
                </div>
            </div>
            <div class="col-6">
                <div class="p-2 rounded bg-label-primary">
                    <h5 class="fw-bold mb-0">{{ $servingNow }}</h5>
                    <small class="text-muted">Serving</small>
                </div>
            </div>
        </div>
    </div>
</div>
