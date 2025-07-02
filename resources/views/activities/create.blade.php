@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body { 
        background: #f4f5f7; 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #172b4d;
        line-height: 1.6;
    }
    
    .create-task-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 24px;
        min-height: 100vh;
    }
    
    .create-task-header {
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
    
    .create-task-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #172b4d;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .create-task-card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #dfe1e6;
        overflow: hidden;
    }
    
    .create-task-form {
        padding: 32px;
    }
    
    .form-grid {
        display: grid;
        gap: 24px;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .form-group.double-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    
    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #172b4d;
        margin: 0;
    }
    
    .form-label .required {
        color: #de350b;
        margin-left: 4px;
    }
    
    .form-control, .form-select {
        border: 2px solid #dfe1e6;
        border-radius: 6px;
        padding: 12px 16px;
        font-size: 14px;
        background: white;
        transition: all 0.2s ease;
        color: #172b4d;
        font-family: inherit;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0052cc;
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
        outline: none;
    }
    
    .form-control.large {
        min-height: 120px;
        resize: vertical;
        font-family: inherit;
    }
    
    .category-select-wrapper {
        position: relative;
    }
    
    .category-option {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .category-color-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        padding: 24px 32px;
        background: #f4f5f7;
        border-top: 1px solid #dfe1e6;
    }
    
    .jira-btn {
        background: #f4f5f7;
        color: #42526e;
        border: 1px solid #dfe1e6;
        border-radius: 6px;
        padding: 12px 24px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        min-width: 120px;
        justify-content: center;
    }
    
    .jira-btn:hover {
        background: #ebecf0;
        color: #172b4d;
        border-color: #c1c7d0;
        text-decoration: none;
        transform: translateY(-1px);
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
    
    .alert {
        border: none;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 24px;
        background: #ffebe6;
        color: #bf2600;
        border-left: 4px solid #de350b;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .form-help-text {
        font-size: 12px;
        color: #6b778c;
        margin-top: 4px;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 16px;
    }
    
    .breadcrumb-item {
        font-size: 14px;
        color: #6b778c;
    }
    
    .breadcrumb-item.active {
        color: #172b4d;
        font-weight: 500;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #97a0af;
        margin: 0 8px;
    }
    
    @media (max-width: 768px) {
        .create-task-container {
            padding: 16px;
        }
        
        .create-task-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }
        
        .create-task-form {
            padding: 24px 20px;
        }
        
        .form-group.double-column {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column-reverse;
            padding: 20px;
        }
        
        .jira-btn {
            width: 100%;
        }
    }
</style>

<div class="create-task-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}" style="color: #0052cc; text-decoration: none;">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Create Task</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="create-task-header">
        <h1>
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Create New Task
        </h1>
        <a href="{{ url('/dashboard') }}" class="jira-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="create-task-card">
        <form method="POST" action="{{ route('activities.store') }}">
            @csrf
            
            <!-- Error Alert -->
            @if($errors->any())
                <div style="padding: 32px 32px 0 32px;">
                    <div class="alert">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <div>
                            <strong>Please correct the following errors:</strong>
                            <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="create-task-form">
                <div class="form-grid">
                    <!-- Task Title -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Task Title<span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="title" 
                            name="title" 
                            placeholder="What needs to be done?"
                            required 
                            value="{{ old('title') }}"
                            autocomplete="off"
                        >
                        <div class="form-help-text">Give your task a clear, descriptive title</div>
                    </div>

                    <!-- Task Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea 
                            class="form-control large" 
                            id="description" 
                            name="description"
                            placeholder="Add more details about this task..."
                            rows="4"
                        >{{ old('description') }}</textarea>
                        <div class="form-help-text">Provide additional context or requirements for this task</div>
                    </div>

                    <!-- Task Links -->
                    <div class="form-group">
                        <label for="links" class="form-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 4px;">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.72-1.71" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Related Links
                        </label>
                        <textarea 
                            class="form-control" 
                            id="links" 
                            name="links"
                            placeholder="Add any relevant links for this task (e.g., documentation, resources, references)..."
                            rows="3"
                        >{{ old('links') }}</textarea>
                        <div class="form-help-text">Optional links that might be useful for completing this task</div>
                    </div>

                    <!-- Deadline and Category Row -->
                    <div class="form-group double-column">
                        <div>
                            <label for="deadline" class="form-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 4px;">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"/>
                                    <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"/>
                                    <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                Due Date
                            </label>
                            <input 
                                type="datetime-local" 
                                class="form-control" 
                                id="deadline" 
                                name="deadline" 
                                value="{{ old('deadline') }}"
                            >
                            <div class="form-help-text">Optional deadline for this task</div>
                        </div>

                        <div>
                            <label for="category_id" class="form-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 4px;">
                                    <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586L17 7.171c.362.362.586.862.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Category
                            </label>
                            <div class="category-select-wrapper">
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">No Category</option>
                                    @foreach($categories as $category)
                                        <option 
                                            value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                            data-color="{{ $category->color ?? '#0052cc' }}"
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-help-text">Organize your task with a category</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ url('/dashboard') }}" class="jira-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="jira-btn primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Create Task
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-focus the title input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('title').focus();
    });

    // Add subtle animation to form controls on focus
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Character counter for title (optional enhancement)
    const titleInput = document.getElementById('title');
    titleInput.addEventListener('input', function() {
        if (this.value.length > 100) {
            this.style.borderColor = '#de350b';
        } else {
            this.style.borderColor = '#dfe1e6';
        }
    });
    
    // Handle form submission with SweetAlert2
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const deadline = document.getElementById('deadline').value;
        const categorySelect = document.getElementById('category_id');
        const categoryName = categorySelect.options[categorySelect.selectedIndex].text;
        
        if (!title) {
            TodoAlert.warning('Task Title Required', 'Please enter a title for your task');
            document.getElementById('title').focus();
            return;
        }
        
        if (title.length > 100) {
            TodoAlert.warning('Title Too Long', 'Task title must be 100 characters or less');
            document.getElementById('title').focus();
            return;
        }
        
        // Create preview of task
        let previewText = `Title: ${title}`;
        if (description) previewText += `\nDescription: ${description.substring(0, 50)}${description.length > 50 ? '...' : ''}`;
        if (deadline) previewText += `\nDeadline: ${new Date(deadline).toLocaleString()}`;
        if (categorySelect.value) previewText += `\nCategory: ${categoryName}`;
        
        TodoAlert.confirm(
            'Create New Task',
            previewText,
            'Create Task',
            'Cancel'
        ).then((result) => {
            if (result.isConfirmed) {
                const loadingAlert = TodoAlert.loading('Creating Task...', 'Please wait while we save your task');
                this.submit();
            }
        });
    });
    
    // Add confirmation for cancel action
    document.querySelector('a[href*="dashboard"]').addEventListener('click', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        
        if (title || description) {
            e.preventDefault();
            
            TodoAlert.warning(
                'Discard Changes?',
                'You have unsaved changes. Are you sure you want to leave?'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = this.href;
                }
            });
        }
    });
</script>
@endsection
