<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Features\Queue;
use App\Models\Features\Counter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Users ──────────────────────────────────────────────────────────────
        $totalUsers     = User::count();
        $newUsersToday  = User::whereDate('created_at', today())->count();
        $newUsersWeek   = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $newUsersMonth  = User::whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();
 
        // Users by gender
        $usersByGender = User::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');
 
        // ── Departments ───────────────────────────────────────────────────────
        // Users grouped by department_code
        $usersByDepartment = User::select('department_code', DB::raw('count(*) as total'))
            ->whereNotNull('department_code')
            ->groupBy('department_code')
            ->orderByDesc('total')
            ->get();
 
        // ── Queue ─────────────────────────────────────────────────────────────
        $queueToday     = Queue::whereDate('created_at', today())->count();
        $servedToday    = Queue::where('status', 'done')->whereDate('created_at', today())->count();
        $waitingNow     = Queue::where('status', 'waiting')->whereDate('created_at', today())->count();
        $servingNow     = Queue::where('status', 'serving')->whereDate('created_at', today())->count();
 
        // Queue per day — last 7 days
        $queuePerDay = Queue::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total'),
                DB::raw('sum(case when status = "done" then 1 else 0 end) as served')
            )
            ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
 
        // Fill missing days with 0
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $last7Days->push([
                'date'    => Carbon::parse($date)->format('D'),
                'full'    => $date,
                'total'   => $queuePerDay[$date]->total  ?? 0,
                'served'  => $queuePerDay[$date]->served ?? 0,
            ]);
        }
 
        // Queue per day — last 30 days
        $queueLast30 = Queue::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [now()->subDays(29)->startOfDay(), now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');
 
        // Queue by category
        $queueByCategory = Queue::select('category', DB::raw('count(*) as total'))
            ->whereDate('created_at', today())
            ->groupBy('category')
            ->pluck('total', 'category');
 
        // Average wait time today (minutes)
        $avgWaitTime = Queue::where('status', 'done')
            ->whereDate('created_at', today())
            ->whereNotNull('called_at')
            ->get()
            ->avg(fn($q) => $q->created_at->diffInMinutes($q->called_at));
 
        // ── Counters ──────────────────────────────────────────────────────────
        $totalCounters  = Counter::count();
        $activeCounters = Counter::where('status', 'active')->count();
        $busyCounters   = Counter::where('status', 'busy')->count();
        $closedCounters = Counter::where('status', 'closed')->count();
        $counters       = Counter::all();
 
        // ── Recent queue (last 10) ────────────────────────────────────────────
        $recentQueue = Queue::with('counter')
            ->whereDate('created_at', today())
            ->latest()
            ->take(10)
            ->get();
 
        return view('dashboard.dashboard_list', compact(
            // Users
            'totalUsers', 'newUsersToday', 'newUsersWeek', 'newUsersMonth',
            'usersByGender', 'usersByDepartment',
            // Queue
            'queueToday', 'servedToday', 'waitingNow', 'servingNow',
            'last7Days', 'queueLast30', 'queueByCategory', 'avgWaitTime',
            // Counters
            'totalCounters', 'activeCounters', 'busyCounters', 'closedCounters', 'counters',
            // Recent
            'recentQueue'
        ));
    }
}
