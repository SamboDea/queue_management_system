<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Features\Queue;
use App\Models\Features\Counter;

class QueueController extends Controller
{
    public function display()
    {
        $counters = Counter::all();
        $waiting  = Queue::where('status', 'waiting')
            ->whereDate('created_at', today())
            ->orderBy('id')
            ->get();
        $serving  = Queue::where('status', 'serving')
            ->whereDate('created_at', today())
            ->with('counter')
            ->get();
        $servedToday = Queue::where('status', 'done')
            ->whereDate('created_at', today())
            ->count();
 
        // Average wait time in minutes
        $avgWait = Queue::where('status', 'done')
            ->whereDate('created_at', today())
            ->whereNotNull('called_at')
            ->get()
            ->avg(fn($q) => $q->created_at->diffInMinutes($q->called_at));
 
        return view('feature.display.display', compact(
            'counters', 'waiting', 'serving', 'servedToday', 'avgWait'
        ));
    }
 
    // ─── Admin panel ─────────────────────────────────────────────────────────
 
    public function index()
    {
        $counters = Counter::all();
        $queues   = Queue::with('counter')
            ->whereDate('created_at', today())
            ->orderByDesc('id')
            ->paginate(20);
        $waiting  = Queue::where('status', 'waiting')
            ->whereDate('created_at', today())
            ->count();
        $serving  = Queue::where('status', 'serving')
            ->whereDate('created_at', today())
            ->count();
        $done     = Queue::where('status', 'done')
            ->whereDate('created_at', today())
            ->count();
 
        return view('feature.queue.list_queue', compact(
            'counters', 'queues', 'waiting', 'serving', 'done'
        ));
    }
 
    // ─── Take a number (kiosk / front desk) ──────────────────────────────────
 
    public function take(Request $request)
    {
        $request->validate([
            'category' => 'required|in:A,B,C',
        ]);
 
        $ticket = Queue::create([
            'ticket_number' => Queue::generateTicket($request->category),
            'category'      => $request->category,
            'status'        => 'waiting',
        ]);
 
        return back()->with('success', "Ticket issued: {$ticket->ticket_number}");
    }
 
    // ─── Call next ticket to a counter ───────────────────────────────────────
 
    public function callNext(Request $request)
    {
        $request->validate([
            'counter_id' => 'required|exists:counters,id',
        ]);
 
        $counter = Counter::findOrFail($request->counter_id);
 
        // Mark current serving ticket as done
        Queue::where('counter_id', $counter->id)
            ->where('status', 'serving')
            ->update([
                'status'    => 'done',
                'served_at' => now(),
            ]);
 
        // Get next waiting ticket (priority: A > B > C by order)
        $next = Queue::where('status', 'waiting')
            ->whereDate('created_at', today())
            ->orderBy('id')
            ->first();
 
        if (!$next) {
            $counter->update(['status' => 'active', 'current_ticket' => null]);
            return back()->with('error', 'No tickets in queue.');
        }
 
        // Assign to counter
        $next->update([
            'status'     => 'serving',
            'counter_id' => $counter->id,
            'called_at'  => now(),
        ]);
 
        $counter->update([
            'status'         => 'active',
            'current_ticket' => $next->ticket_number,
        ]);
 
        return back()->with('success', "Called {$next->ticket_number} to {$counter->name}.");
    }
 
    // ─── Skip a ticket ────────────────────────────────────────────────────────
 
    public function skip(Queue $queue)
    {
        $queue->update(['status' => 'skip']);
 
        if ($queue->counter_id) {
            Counter::find($queue->counter_id)?->update([
                'status'         => 'active',
                'current_ticket' => null,
            ]);
        }
 
        return back()->with('success', "Ticket {$queue->ticket_number} skipped.");
    }
 
    // ─── Mark done manually ───────────────────────────────────────────────────
 
    public function done(Queue $queue)
    {
        $queue->update(['status' => 'done', 'served_at' => now()]);
 
        if ($queue->counter_id) {
            Counter::find($queue->counter_id)?->update([
                'status'         => 'active',
                'current_ticket' => null,
            ]);
        }
 
        return back()->with('success', "Ticket {$queue->ticket_number} marked as done.");
    }
 
    // ─── Toggle counter open/close ────────────────────────────────────────────
 
    public function toggleCounter(Counter $counter)
    {
        $status = $counter->status === 'closed' ? 'active' : 'closed';
        $counter->update(['status' => $status]);
 
        return back()->with('success', "{$counter->name} is now {$status}.");
    }
 
    // ─── JSON for live polling ────────────────────────────────────────────────
 
    public function liveData()
    {
        return response()->json([
            'counters' => Counter::all(),
            'waiting'  => Queue::where('status', 'waiting')
                ->whereDate('created_at', today())
                ->orderBy('id')
                ->get(),
            'serving'  => Queue::where('status', 'serving')
                ->whereDate('created_at', today())
                ->with('counter')
                ->get(),
            'served_today' => Queue::where('status', 'done')
                ->whereDate('created_at', today())
                ->count(),
        ]);
    }
}
