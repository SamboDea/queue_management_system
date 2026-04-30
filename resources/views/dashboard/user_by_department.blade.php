 <div class="card h-100">
     <div class="card-header d-flex align-items-center justify-content-between">
         <h5 class="mb-0">Users by Department</h5>
         <span class="badge bg-label-primary">{{ $usersByDepartment->count() }} dept</span>
     </div>
     <div class="card-body p-0">
         <ul class="list-group list-group-flush">
             @forelse ($usersByDepartment as $dept)
                 @php
                     $pct = $totalUsers > 0 ? round(($dept->total / $totalUsers) * 100) : 0;
                     $colors = ['primary', 'warning', 'success', 'info', 'danger', 'secondary'];
                     $color = $colors[$loop->index % count($colors)];
                 @endphp
                 <li class="list-group-item px-4 py-3">
                     <div class="d-flex align-items-center justify-content-between mb-1">
                         <div class="d-flex align-items-center gap-2">
                             <div class="avatar avatar-xs">
                                 <span class="avatar-initial rounded bg-label-{{ $color }}">
                                     {{ strtoupper(substr($dept->department_code, 0, 1)) }}
                                 </span>
                             </div>
                             <span style="font-size:13px;font-weight:500">
                                 {{ $dept->department_code }}
                             </span>
                         </div>
                         <div class="d-flex align-items-center gap-2">
                             <span style="font-size:13px;font-weight:600">{{ $dept->total }}</span>
                             <span class="text-muted" style="font-size:11px">{{ $pct }}%</span>
                         </div>
                     </div>
                     <div class="progress" style="height:4px;border-radius:4px">
                         <div class="progress-bar bg-{{ $color }}" style="width:{{ $pct }}%">
                         </div>
                     </div>
                 </li>
             @empty
                 <li class="list-group-item text-center py-4 text-muted">
                     No department data
                 </li>
             @endforelse
         </ul>
     </div>
 </div>
