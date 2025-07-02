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
        // Sorting
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);
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
        ]);
        
        $data = $request->only('title', 'description', 'deadline', 'category_id');
        
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
        return redirect('/dashboard')->with('success', 'Activity created successfully!');
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
        ]);
        
        $data = $request->only('title', 'description', 'deadline', 'category_id');
        
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
        return redirect('/dashboard')->with('success', 'Activity updated successfully!');
    }

    public function destroy(Activity $activity)
    {
        // Check if user has permission to delete this activity
        $currentUser = getCurrentUser();
        if ($currentUser && $activity->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this activity.');
        }
        
        $activity->delete();
        return redirect('/dashboard')->with('success', 'Activity deleted successfully!');
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
        return redirect('/dashboard')->with('success', 'Activity status updated successfully!');
    }

    public function bulkEdit(Request $request)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:activities,id',
            'bulk_status' => 'nullable|in:pending,in_progress,completed',
            'bulk_category_id' => 'nullable|exists:categories,id',
        ]);
        
        $currentUser = getCurrentUser();
        $query = Activity::whereIn('id', $request->task_ids);
        
        // Ensure user can only bulk edit their own activities
        if ($currentUser) {
            $query->where('user_id', $currentUser->id);
            
            // Validate category belongs to user
            if ($request->filled('bulk_category_id')) {
                $category = Category::where('id', $request->bulk_category_id)
                                   ->where('user_id', $currentUser->id)
                                   ->first();
                if (!$category) {
                    return back()->withErrors(['bulk_category_id' => 'Selected category is not valid.']);
                }
            }
        }
        
        $data = [];
        if ($request->filled('bulk_status')) {
            $data['status'] = $request->bulk_status;
        }
        if ($request->filled('bulk_category_id')) {
            $data['category_id'] = $request->bulk_category_id;
        }
        if (!empty($data)) {
            $query->update($data);
        }
        return redirect('/dashboard')->with('success', 'Selected tasks updated successfully!');
    }
}
