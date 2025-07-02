<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query();
        
        // Filter by current user (if not master user)
        $currentUser = getCurrentUser();
        if ($currentUser) {
            $query->where('user_id', $currentUser->id);
        } elseif (!isMasterUser()) {
            // If no user session and not master, show no activities
            $query->whereRaw('1 = 0');
        }
        
        // Filtering by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        // Filtering by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filtering by deadline
        if ($request->filled('deadline_filter')) {
            switch ($request->deadline_filter) {
                case 'with_deadline':
                    $query->whereNotNull('deadline');
                    break;
                case 'upcoming':
                    $query->whereBetween('deadline', [now(), now()->addWeek()]);
                    break;
                case 'overdue':
                    $query->where('deadline', '<', now());
                    break;
                case 'no_deadline':
                    $query->whereNull('deadline');
                    break;
            }
        }
        // Sorting
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        // Special handling for deadline sorting to handle NULL values properly
        if ($sort === 'deadline') {
            if ($direction === 'asc') {
                // For ascending: urgent deadlines first (earliest to latest), then tasks without deadlines
                $query->orderByRaw('CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline ASC');
            } else {
                // For descending: latest deadlines first, then tasks without deadlines
                $query->orderByRaw('CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline DESC');
            }
        } else {
            $query->orderBy($sort, $direction);
        }
        
        $activities = $query->get();
        
        // Get categories for current user
        if ($currentUser) {
            $categories = Category::where('user_id', $currentUser->id)->get();
        } elseif (isMasterUser()) {
            $categories = Category::all();
        } else {
            $categories = collect();
        }
        
        return view('dashboard', compact('activities', 'categories'));
    }

    public function create()
    {
        $currentUser = getCurrentUser();
        if ($currentUser) {
            $categories = Category::where('user_id', $currentUser->id)->get();
        } elseif (isMasterUser()) {
            $categories = Category::all();
        } else {
            $categories = collect();
        }
        return view('activities.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'links' => 'nullable|string',
        ]);
        
        $data = $request->only('title', 'description', 'deadline', 'category_id', 'links');
        
        // Add user_id for regular users
        $currentUser = getCurrentUser();
        if ($currentUser) {
            $data['user_id'] = $currentUser->id;
            
            // Validate that category belongs to current user
            if ($data['category_id']) {
                $category = Category::where('id', $data['category_id'])
                                   ->where('user_id', $currentUser->id)
                                   ->first();
                if (!$category) {
                    return back()->withErrors(['category_id' => 'Selected category is not valid.']);
                }
            }
        }
        
        Activity::create($data);
        return redirect('/dashboard')->with('success', '🎉 Task Created Successfully! Your new task has been added to your dashboard.');
    }

    public function edit(Activity $activity)
    {
        // Check if user has permission to edit this activity
        $currentUser = getCurrentUser();
        if ($currentUser && $activity->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this activity.');
        }
        
        if ($currentUser) {
            $categories = Category::where('user_id', $currentUser->id)->get();
        } elseif (isMasterUser()) {
            $categories = Category::all();
        } else {
            $categories = collect();
        }
        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(Request $request, Activity $activity)
    {
        // Check if user has permission to update this activity
        $currentUser = getCurrentUser();
        if ($currentUser && $activity->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this activity.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'links' => 'nullable|string',
        ]);
        
        $data = $request->only('title', 'description', 'deadline', 'category_id', 'links');
        
        // Validate that category belongs to current user
        if ($currentUser && $data['category_id']) {
            $category = Category::where('id', $data['category_id'])
                               ->where('user_id', $currentUser->id)
                               ->first();
            if (!$category) {
                return back()->withErrors(['category_id' => 'Selected category is not valid.']);
            }
        }
        
        $activity->update($data);
        return redirect('/dashboard')->with('success', '✅ Task Updated! Your changes have been saved successfully.');
    }

    public function destroy(Activity $activity)
    {
        // Check if user has permission to delete this activity
        $currentUser = getCurrentUser();
        if ($currentUser && $activity->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this activity.');
        }
        
        $activity->delete();
        return redirect('/dashboard')->with('success', '🗑️ Task Deleted! The task has been removed from your dashboard.');
    }

    public function setStatus(Activity $activity, $status)
    {
        // Check if user has permission to update this activity
        $currentUser = getCurrentUser();
        if ($currentUser && $activity->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this activity.');
        }
        
        if (in_array($status, ['pending', 'in_progress', 'completed'])) {
            $activity->status = $status;
            $activity->save();
        }
        return redirect('/dashboard')->with('success', '🔄 Status Updated! Task status has been changed successfully.');
    }

    public function quickCategoryAssign(Request $request, Activity $activity)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        // Check if user has permission to update this activity
        $currentUser = getCurrentUser();
        if ($currentUser && $activity->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this activity.');
        }
        
        // Validate category belongs to user if category_id is provided
        if ($request->filled('category_id') && $currentUser) {
            $category = Category::where('id', $request->category_id)
                               ->where('user_id', $currentUser->id)
                               ->first();
            if (!$category) {
                return response()->json(['success' => false, 'message' => 'Selected category is not valid.'], 400);
            }
        }
        
        $activity->category_id = $request->category_id;
        $activity->save();
        
        return response()->json([
            'success' => true, 
            'message' => '📋 Category Updated! Task category has been changed successfully.',
            'category' => $activity->category
        ]);
    }
}
