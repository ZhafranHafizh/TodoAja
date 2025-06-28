<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderByDesc('created_at')->get();
        return view('dashboard', compact('activities'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Activity::create($request->only('title', 'description'));
        return redirect('/dashboard')->with('success', 'Activity created!');
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $activity->update($request->only('title', 'description'));
        return redirect('/dashboard')->with('success', 'Activity updated!');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect('/dashboard')->with('success', 'Activity deleted!');
    }
}
