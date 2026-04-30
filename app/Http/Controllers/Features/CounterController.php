<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Features\Counter;

class CounterController extends Controller
{
    // public function index()
    // {
    //     $counters = Counter::latest()->paginate(10);
    //     return view('feature.counters.list_counter', compact('counters'));
    // }

    public function index()
    {
        $counters = Counter::latest()->paginate(10);

        $totalActive = Counter::where('status', 'active')->count();
        $totalBusy   = Counter::where('status', 'busy')->count();
        $totalClosed = Counter::where('status', 'closed')->count();

        return view('feature.counters.list_counter', compact(
            'counters',
            'totalActive',
            'totalBusy',
            'totalClosed'
        ));
    }

    public function create()
    {
        return view('feature.counters.create_counter');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'code'   => 'required|string|max:10|unique:counters,code',
            'status' => 'required|in:active,busy,closed',
        ]);

        Counter::create($request->only('name', 'code', 'status'));

        return redirect()->route('counters.index')
            ->with('success', "Counter {$request->name} created successfully.");
    }

    public function edit(Counter $counter)
    {
        return view('feature.counters.edit_counter', compact('counter'));
    }

    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'code'   => 'required|string|max:10|unique:counters,code,' . $counter->id,
            'status' => 'required|in:active,busy,closed',
        ]);

        $counter->update($request->only('name', 'code', 'status'));

        return redirect()->route('counters.index')
            ->with('success', "Counter {$counter->name} updated successfully.");
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();

        return redirect()->route('counters.index')
            ->with('success', 'Counter deleted successfully.');
    }
}
