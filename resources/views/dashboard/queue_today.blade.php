<div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="bx bx-receipt"></i>
                            </span>
                        </div>
                        <span class="badge bg-label-info" style="font-size:10px">Today</span>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $queueToday }}</h4>
                    <small class="text-muted">Tickets Issued</small>
                    <div class="mt-2" style="font-size:11px;color:#aaa">
                        <i class="bx bx-check-circle text-success"></i> {{ $servedToday }} served
                    </div>
                </div>
            </div>