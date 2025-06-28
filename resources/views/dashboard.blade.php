@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Dashboard</span>
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                    </form>
                </div>
                <div class="card-body">
                    <h5>Welcome to TodoAja!</h5>
                    <p>This is your personal productivity dashboard.</p>
                    <hr>
                    <a href="{{ route('activities.create') }}" class="btn btn-primary">Add Activity</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Your Activities</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(isset($activities) && $activities->count())
                        <ul class="list-group">
                            @foreach($activities as $activity)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $activity->title }}</strong>
                                        <div class="text-muted small">{{ $activity->description }}</div>
                                    </div>
                                    <div>
                                        <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this activity?')">Delete</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No activities yet. Start by adding one!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
