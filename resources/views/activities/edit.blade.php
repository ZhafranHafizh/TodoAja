@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 mb-1 text-dark fw-bold">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Edit Activity
                    </h2>
                    <p class="text-muted mb-0">Update activity details and track your progress</p>
                </div>
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>

            <!-- Main Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('activities.update', $activity) }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="title" class="form-label text-dark fw-semibold">
                                        <i class="bi bi-card-text text-primary me-1"></i>Activity Title *
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg border-0 bg-light" 
                                           id="title" 
                                           name="title" 
                                           required 
                                           value="{{ old('title', $activity->title) }}"
                                           placeholder="Enter activity title...">
                                    <div class="invalid-feedback">Please provide a valid activity title.</div>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label text-dark fw-semibold">
                                        <i class="bi bi-file-text text-success me-1"></i>Description
                                    </label>
                                    <textarea class="form-control border-0 bg-light" 
                                              id="description" 
                                              name="description" 
                                              rows="4"
                                              placeholder="Add activity description...">{{ old('description', $activity->description) }}</textarea>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="deadline" class="form-label text-dark fw-semibold">
                                        <i class="bi bi-calendar-event text-warning me-1"></i>Deadline
                                    </label>
                                    <input type="datetime-local" 
                                           class="form-control border-0 bg-light" 
                                           id="deadline" 
                                           name="deadline" 
                                           value="{{ old('deadline', $activity->deadline ? date('Y-m-d\TH:i', strtotime($activity->deadline)) : '') }}">
                                </div>

                                <div class="mb-4">
                                    <label for="category_id" class="form-label text-dark fw-semibold">
                                        <i class="bi bi-tag text-info me-1"></i>Category
                                    </label>
                                    <select class="form-select border-0 bg-light" id="category_id" name="category_id">
                                        <option value="">
                                            <i class="bi bi-circle text-muted"></i> No Category
                                        </option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $activity->category_id) == $category->id ? 'selected' : '' }}
                                                    data-color="{{ $category->color ?? '#6c757d' }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($activity->category)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center p-3 rounded" style="background-color: {{ $activity->category->color }}20; border-left: 4px solid {{ $activity->category->color }};">
                                        <div class="rounded-circle me-2" style="width: 12px; height: 12px; background-color: {{ $activity->category->color }};"></div>
                                        <small class="text-muted">Current: {{ $activity->category->name }}</small>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ url('/dashboard') }}" class="btn btn-light border-0">
                                <i class="bi bi-x-lg me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i>Update Activity
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    background-color: white !important;
}

.card {
    transition: all 0.2s ease;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Category option styling */
#category_id option {
    padding: 8px 12px;
}
</style>

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Category color preview
document.getElementById('category_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const color = selectedOption.getAttribute('data-color') || '#6c757d';
    
    // Update the select styling based on category color
    if (this.value) {
        this.style.borderLeft = `3px solid ${color}`;
    } else {
        this.style.borderLeft = 'none';
    }
});

// Initialize category color on page load
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const color = selectedOption.getAttribute('data-color') || '#6c757d';
    
    if (categorySelect.value) {
        categorySelect.style.borderLeft = `3px solid ${color}`;
    }
});
</script>
@endsection
