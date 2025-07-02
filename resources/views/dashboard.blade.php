@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body { 
        background: #f4f5f7; 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #172b4d;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }
    
    .jira-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 24px;
        min-height: 100vh;
    }
    
    .jira-header {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #dfe1e6;
        margin-bottom: 24px;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .jira-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #172b4d;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .jira-header .header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .jira-card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #dfe1e6;
        margin-bottom: 24px;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }
    
    .jira-card:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }
    
    .sidebar-card {
        position: sticky;
        top: 24px;
        margin-bottom: 0;
    }
    
    .jira-card-header {
        background: #f4f5f7;
        border-bottom: 1px solid #dfe1e6;
        padding: 16px 24px;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #172b4d;
    }
    
    .sidebar-header {
        padding: 16px 24px;
        font-size: 12px;
        font-weight: 600;
        color: #6b778c;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #dfe1e6;
        background: #f4f5f7;
    }
    
    .jira-btn {
        background: #f4f5f7;
        color: #42526e;
        border: 1px solid #dfe1e6;
        border-radius: 4px;
        padding: 8px 12px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        line-height: 1;
    }
    
    .jira-btn:hover {
        background: #ebecf0;
        color: #172b4d;
        border-color: #c1c7d0;
        text-decoration: none;
    }
    
    .jira-btn.primary {
        background: #0052cc;
        color: white;
        border-color: #0052cc;
    }
    
    .jira-btn.primary:hover {
        background: #0747a6;
        color: white;
        border-color: #0747a6;
    }
    
    .jira-btn.danger {
        background: #de350b;
        color: white;
        border-color: #de350b;
        padding: 4px 8px;
        font-size: 12px;
    }
    
    .jira-btn.danger:hover {
        background: #bf2600;
        color: white;
        border-color: #bf2600;
    }
    
    .jira-btn.ghost {
        background: transparent;
        border: none;
        padding: 6px 8px;
        font-size: 12px;
        color: #6b778c;
    }
    
    .jira-btn.ghost:hover {
        background: #f4f5f7;
        color: #172b4d;
    }
    
    .jira-list-group {
        border: none;
        background: transparent;
    }
    
    .jira-list-item {
        border: none;
        border-bottom: 1px solid #dfe1e6;
        padding: 12px 24px;
        display: flex;
        align-items: center;
        background: transparent;
        transition: background 0.15s ease;
        min-height: 48px;
    }
    
    .jira-list-item:hover {
        background: #f4f5f7;
    }
    
    .jira-list-item:last-child {
        border-bottom: none;
    }
    
    .jira-list-item.active {
        background: #deebff;
        border-left: 3px solid #0052cc;
        padding-left: 21px;
        color: #0052cc;
        font-weight: 500;
    }
    
    .category-item {
        justify-content: space-between;
        padding: 12px 24px;
    }
    
    .category-link {
        text-decoration: none;
        color: #42526e;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .category-link:hover {
        color: #0052cc;
        text-decoration: none;
    }
    
    .activity-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 4px;
        color: #172b4d;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .activity-desc {
        color: #6b778c;
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 8px;
    }
    
    .jira-empty {
        color: #97a0af;
        text-align: center;
        padding: 48px 32px;
        font-size: 14px;
    }
    
    .jira-badge {
        background: #dfe1e6;
        color: #42526e;
        border: none;
        border-radius: 12px;
        padding: 4px 8px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .jira-badge.pending {
        background: #fff4e6;
        color: #b25000;
    }
    
    .jira-badge.in-progress {
        background: #deebff;
        color: #0052cc;
    }
    
    .jira-badge.completed {
        background: #e3fcef;
        color: #006644;
    }
    
    .jira-badge.category {
        background: #eae6ff;
        color: #5243aa;
    }
    
    .category-color-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .color-picker-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    
    .color-option {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    
    .color-option:hover {
        transform: scale(1.1);
        border-color: #172b4d;
    }
    
    .color-option.selected {
        border-color: #0052cc;
        transform: scale(1.2);
    }
    
    .color-option.selected::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 12px;
        font-weight: bold;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
    }
    
    .category-form-expanded {
        background: #f4f5f7;
        border-top: 1px solid #dfe1e6;
        padding: 16px 24px;
    }
    
    .form-group {
        margin-bottom: 12px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 4px;
        font-size: 12px;
        color: #6b778c;
        font-weight: 600;
    }
    
    .jira-badge.deadline {
        background: #ffebe6;
        color: #bf2600;
    }
    
    .filter-section {
        background: #f4f5f7;
        border-bottom: 1px solid #dfe1e6;
        padding: 16px 24px;
    }
    
    .form-control, .form-select {
        border: 1px solid #dfe1e6;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 14px;
        background: white;
        transition: border-color 0.15s ease;
        color: #172b4d;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0052cc;
        box-shadow: 0 0 0 2px rgba(0, 82, 204, 0.2);
        outline: none;
    }
    
    .form-label {
        font-size: 12px;
        color: #6b778c;
        font-weight: 600;
        margin-bottom: 4px;
    }
    
    .bulk-edit-panel {
        background: #f4f5f7;
        border: 1px solid #dfe1e6;
        border-radius: 8px;
        padding: 16px;
        margin: 16px 24px;
    }
    
    .task-checkbox {
        margin-right: 16px;
        transform: scale(1.1);
        accent-color: #0052cc;
    }
    
    .task-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
    }
    
    .activity-item {
        padding: 16px 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        border-bottom: 1px solid #dfe1e6;
        transition: all 0.15s ease;
    }
    
    .activity-item:hover {
        background: #f4f5f7;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-content {
        flex-grow: 1;
        min-width: 0;
    }
    
    .category-form {
        padding: 16px 24px;
        background: #f4f5f7;
        border-top: 1px solid #dfe1e6;
    }
    
    .alert {
        border: none;
        border-radius: 8px;
        margin: 16px 24px;
        padding: 16px;
        background: #e3fcef;
        color: #006644;
        border-left: 4px solid #00875a;
        font-size: 14px;
    }
    
    @media (max-width: 768px) {
        .jira-container {
            padding: 16px;
        }
        
        .activity-item {
            flex-direction: column;
            gap: 16px;
        }
        
        .task-actions {
            align-self: stretch;
            justify-content: flex-end;
        }
        
        .jira-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }
        
        .filter-section .d-flex {
            flex-direction: column;
            gap: 12px;
        }
        
        .filter-section .d-flex > div {
            width: 100%;
        }
    }
</style>

<div class="jira-container">
    <!-- Main Header -->
    <div class="jira-header">
        <h1>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            TodoAja Dashboard
            @if(getCurrentUser())
                <span style="font-size: 14px; font-weight: 400; color: #6b778c; margin-left: 16px;">
                    {{ getCurrentUser()->email }}
                </span>
            @elseif(isMasterUser())
                <span style="font-size: 14px; font-weight: 400; color: #6b778c; margin-left: 16px;">
                    Master Account
                </span>
            @endif
        </h1>
        <div class="header-actions">
            <a href="{{ route('activities.create') }}" class="jira-btn primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Create Task
            </a>
            <form method="POST" action="{{ url('/logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="jira-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4m7 14l5-5-5-5m5 5H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="jira-card sidebar-card">
                <div class="sidebar-header">Project Navigation</div>
                <ul class="list-group jira-list-group">
                    <li class="jira-list-item category-item {{ !request('category_id') ? 'active' : '' }}">
                        <a href="{{ url('/dashboard') }}" class="category-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            All Tasks
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li class="jira-list-item category-item {{ request('category_id') == $category->id ? 'active' : '' }}">
                            <a href="{{ url('/dashboard?category_id=' . $category->id) }}" class="category-link">
                                <span class="category-color-dot" style="background-color: {{ $category->color ?? '#0052cc' }}"></span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586L17 7.171c.362.362.586.862.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                {{ $category->name }}
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="jira-btn ghost" onclick="return confirm('Delete this category?')" title="Delete category">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <div class="category-form-expanded">
                    <form method="POST" action="{{ route('categories.store') }}" id="category-form">
                        @csrf
                        <div class="form-group">
                            <label for="category-name">Category Name</label>
                            <input type="text" name="name" id="category-name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="form-group">
                            <label>Choose Color</label>
                            <div class="color-picker-container">
                                <input type="hidden" name="color" id="selected-color" value="#0052cc">
                                <div class="color-option selected" data-color="#0052cc" style="background-color: #0052cc;" title="Blue"></div>
                                <div class="color-option" data-color="#00875a" style="background-color: #00875a;" title="Green"></div>
                                <div class="color-option" data-color="#de350b" style="background-color: #de350b;" title="Red"></div>
                                <div class="color-option" data-color="#ff8b00" style="background-color: #ff8b00;" title="Orange"></div>
                                <div class="color-option" data-color="#5243aa" style="background-color: #5243aa;" title="Purple"></div>
                                <div class="color-option" data-color="#206a83" style="background-color: #206a83;" title="Teal"></div>
                                <div class="color-option" data-color="#bf2600" style="background-color: #bf2600;" title="Dark Red"></div>
                                <div class="color-option" data-color="#403294" style="background-color: #403294;" title="Indigo"></div>
                                <div class="color-option" data-color="#974f0c" style="background-color: #974f0c;" title="Brown"></div>
                                <div class="color-option" data-color="#42526e" style="background-color: #42526e;" title="Gray"></div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="jira-btn primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Add Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9 col-md-8">
            <!-- Activities Card -->
            <div class="jira-card">
                <div class="jira-card-header">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Your Activities
                    </span>
                </div>
                
                <!-- Filter Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ url('/dashboard') }}" class="d-flex flex-wrap gap-3 align-items-end">
                        <div class="flex-fill">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="flex-fill">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                            </select>
                        </div>
                        <div class="flex-fill">
                            <label class="form-label">Order</label>
                            <select name="direction" class="form-select">
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="jira-btn primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                                    <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Bulk Edit Form -->
                @if(isset($activities) && $activities->count())
                    <form id="bulk-edit-form" method="POST" action="{{ route('activities.bulkEdit') }}" class="bulk-edit-panel d-none">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="task_ids[]" id="bulk-task-ids">
                        <div class="row g-3 align-items-end">
                            <div class="col-auto">
                                <label for="bulk_status" class="form-label">Status</label>
                                <select name="bulk_status" id="bulk_status" class="form-select">
                                    <option value="">-- No Change --</option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <label for="bulk_category_id" class="form-label">Category</label>
                                <select name="bulk_category_id" id="bulk_category_id" class="form-select">
                                    <option value="">-- No Change --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="jira-btn primary">Apply to Selected</button>
                            </div>
                        </div>
                    </form>
                @endif

                <!-- Activities List -->
                <div class="p-0">
                    @if(isset($activities) && $activities->count())
                        @foreach($activities as $activity)
                            <div class="activity-item">
                                <div class="form-check">
                                    <input class="form-check-input bulk-task-checkbox task-checkbox" type="checkbox" value="{{ $activity->id }}">
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        {{ $activity->title }}
                                        <span class="jira-badge {{ str_replace('_', '-', $activity->status) }}">
                                            {{ str_replace('_', ' ', $activity->status) }}
                                        </span>
                                        @if($activity->category)
                                            <span class="jira-badge category" style="background-color: {{ $activity->category->color ?? '#5243aa' }}20; color: {{ $activity->category->color ?? '#5243aa' }}; border: 1px solid {{ $activity->category->color ?? '#5243aa' }}40;">{{ $activity->category->name }}</span>
                                        @endif
                                    </div>
                                    <div class="activity-desc">
                                        {{ $activity->description }}
                                        @if($activity->deadline)
                                            <br><span class="jira-badge deadline">Due: {{ \Carbon\Carbon::parse($activity->deadline)->format('M j, Y H:i') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="task-actions">
                                    @if($activity->status !== 'completed')
                                        <form action="{{ route('activities.setStatus', ['activity' => $activity->id, 'status' => $activity->status === 'pending' ? 'in_progress' : 'completed']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="jira-btn primary">
                                                {{ $activity->status === 'pending' ? 'Start' : 'Complete' }}
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('activities.edit', $activity) }}" class="jira-btn">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="jira-btn danger" onclick="return confirm('Delete this activity?')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <polyline points="3,6 5,6 21,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="jira-empty">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 16px; opacity: 0.5;">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <br>No activities yet.<br>
                            <a href="{{ route('activities.create') }}" style="color: #0052cc; text-decoration: none; font-weight: 500;">Create your first task to get started!</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Color picker functionality
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Update hidden input value
            document.getElementById('selected-color').value = this.dataset.color;
        });
    });

    // Bulk edit functionality
    const checkboxes = document.querySelectorAll('.bulk-task-checkbox');
    const bulkForm = document.getElementById('bulk-edit-form');
    function updateBulkFormInputs() {
        // Remove old hidden inputs
        document.querySelectorAll('.bulk-task-id-input').forEach(e => e.remove());
        // Add new hidden inputs for each checked
        const selected = Array.from(checkboxes).filter(c => c.checked).map(c => c.value);
        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'task_ids[]';
            input.value = id;
            input.classList.add('bulk-task-id-input');
            bulkForm.appendChild(input);
        });
        if (selected.length > 0) {
            bulkForm.classList.remove('d-none');
        } else {
            bulkForm.classList.add('d-none');
        }
    }
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkFormInputs);
    });
    if (bulkForm) {
        bulkForm.addEventListener('submit', updateBulkFormInputs);
    }
</script>
@endsection