@extends('layouts.dashboard.main')
@section('content')
    {{-- Page header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dashboard</h4>
            <p class="text-muted mb-0" style="font-size:13px">
                {{ now()->format('l, d F Y') }}
            </p>
        </div>
        <a href="{{ route('queue.display') }}" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="bx bx-desktop me-1"></i> Display Screen
        </a>
    </div>

    {{-- ── Row 1: Top stats ── --}}
    <div class="row g-3 mb-4">

        {{-- Total Users --}}
        <div class="col-6 col-sm-3">
            @include('dashboard.total_user')
        </div>

        {{-- Queue Today --}}
        <div class="col-6 col-sm-3">
            @include('dashboard.queue_today')
        </div>

        {{-- Waiting Now --}}
        <div class="col-6 col-sm-3">
            @include('dashboard.waiting')
        </div>

        {{-- Active Counters --}}
        <div class="col-6 col-sm-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bxs-discount"></i>
                            </span>
                        </div>
                        <span class="badge bg-label-secondary" style="font-size:10px">
                            {{ $closedCounters }} closed
                        </span>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $activeCounters + $busyCounters }}</h4>
                    <small class="text-muted">Open Counters</small>
                    <div class="mt-2" style="font-size:11px;color:#aaa">
                        <i class="bx bx-server text-info"></i> {{ $totalCounters }} total counters
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Row 2: Charts ── --}}
    <div class="row g-4 mb-4">

        {{-- Queue per day — bar chart --}}
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Queue per Day</h5>
                    <small class="text-muted">Last 7 days</small>
                </div>
                <div class="card-body">
                    <canvas id="queueBarChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Queue by category — doughnut --}}
        <div class="col-12 col-lg-4">
            @include('dashboard.queue_by_category')
        </div>

    </div>

    {{-- ── Row 3: Department + Counter status + Users ── --}}
    <div class="row g-4 mb-4">

        {{-- Users by Department --}}
        <div class="col-12 col-lg-4">
            @include('dashboard.user_by_department')
        </div>

        {{-- Counter status --}}
        <div class="col-12 col-lg-4">
            @include('dashboard.counter_status')
        </div>

        {{-- User stats --}}
        <div class="col-12 col-lg-4">
            @include('dashboard.user_state')
            {{-- Queue summary mini --}}
            @include('dashboard.queue_summary')
        </div>

    </div>

    {{-- ── Row 4: Recent queue table ── --}}
    @include('dashboard.recent_queue')

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        const isDark = document.documentElement.classList.contains('dark-style');
        const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
        const labelColor = isDark ? 'rgba(255,255,255,0.55)' : '#697a8d';

        // ── Queue Bar Chart ────────────────────────────────────────────────────────
        const barCtx = document.getElementById('queueBarChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($last7Days->pluck('date')) !!},
                datasets: [{
                        label: 'Total Tickets',
                        data: {!! json_encode($last7Days->pluck('total')) !!},
                        backgroundColor: 'rgba(105,108,255,0.85)',
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Served',
                        data: {!! json_encode($last7Days->pluck('served')) !!},
                        backgroundColor: 'rgba(113,221,55,0.75)',
                        borderRadius: 6,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: labelColor,
                            font: {
                                size: 12
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: labelColor
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: labelColor,
                            stepSize: 1
                        },
                        beginAtZero: true
                    },
                }
            }
        });

        // ── Category Doughnut ──────────────────────────────────────────────────────
        const catCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: ['General (A)', 'Finance (B)', 'VIP (C)'],
                datasets: [{
                    data: [
                        {{ $queueByCategory['A'] ?? 0 }},
                        {{ $queueByCategory['B'] ?? 0 }},
                        {{ $queueByCategory['C'] ?? 0 }},
                    ],
                    backgroundColor: [
                        'rgba(105,108,255,0.85)',
                        'rgba(255,171,0,0.85)',
                        'rgba(113,221,55,0.85)',
                    ],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                }
            }
        });

        // ── Gender Bar Chart ───────────────────────────────────────────────────────
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'bar',
            data: {
                labels: ['Male', 'Female', 'Other'],
                datasets: [{
                    data: [
                        {{ $usersByGender['male'] ?? 0 }},
                        {{ $usersByGender['female'] ?? 0 }},
                        {{ $usersByGender['other'] ?? 0 }},
                    ],
                    backgroundColor: [
                        'rgba(105,108,255,0.8)',
                        'rgba(255,105,180,0.8)',
                        'rgba(113,221,55,0.8)',
                    ],
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: labelColor,
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: labelColor,
                            stepSize: 1
                        },
                        beginAtZero: true
                    },
                }
            }
        });
    </script>
@endsection
