<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $currentUser = getCurrentUser();
        if ($currentUser) {
            $categories = Category::where('user_id', $currentUser->id)->get();
        } elseif (isMasterUser()) {
            $categories = Category::all();
        } else {
            $categories = collect();
        }
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|regex:/^#[0-9a-fA-F]{6}$/'
        ]);
        
        $data = [
            'name' => $request->name,
            'color' => $request->color
        ];
        
        // Add user_id for regular users
        $currentUser = getCurrentUser();
        if ($currentUser) {
            $data['user_id'] = $currentUser->id;
        }
        
        Category::create($data);
        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function update(Request $request, Category $category)
    {
        // Check if user has permission to update this category
        $currentUser = getCurrentUser();
        if ($currentUser && $category->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this category.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|regex:/^#[0-9a-fA-F]{6}$/'
        ]);
        $category->update([
            'name' => $request->name,
            'color' => $request->color
        ]);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Check if user has permission to delete this category
        $currentUser = getCurrentUser();
        if ($currentUser && $category->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this category.');
        }
        
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
