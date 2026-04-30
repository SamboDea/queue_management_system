 <div class="card h-100">
     <div class="card-body">
         <div class="d-flex align-items-center justify-content-between mb-2">
             <div class="avatar">
                 <span class="avatar-initial rounded bg-label-warning">
                     <i class="bx bx-time"></i>
                 </span>
             </div>
             <span class="badge bg-label-primary" style="font-size:10px">
                 {{ $servingNow }} serving
             </span>
         </div>
         <h4 class="fw-bold mb-0">{{ $waitingNow }}</h4>
         <small class="text-muted">Waiting Now</small>
         <div class="mt-2" style="font-size:11px;color:#aaa">
             <i class="bx bx-stopwatch text-warning"></i>
             ~{{ $avgWaitTime ? round($avgWaitTime) : '—' }} min avg wait
         </div>
     </div>
 </div>
