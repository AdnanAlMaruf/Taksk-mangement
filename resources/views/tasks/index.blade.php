@extends('tasks.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Task Management</h2>
            </div>
            <div class="pull-right mb-3 mt-3">
                <a class="btn btn-success" href="{{ route('tasks.create') }}"> Create New Task</a>
            </div>
        </div>
    </div>

    <!-- Filter and Sort Form -->
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="status" class="form-control">
                    <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All Statuses</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-control">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Due Date</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter & Sort</button>
            </div>
        </div>
    </form>

    {{-- Success Message here--}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <!-- Task Table -->
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th>Status</th>
            <th>Due Date</th>
            <th width="280px">Action</th>
        </tr>

        @forelse ($tasks as $task)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->detail }}</td>
                <td>{{ $task->status }}</td>
                {{-- <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td> --}}
                <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') : 'N/A' }}</td>
                <td>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('tasks.show', $task->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No tasks found.</td>
            </tr>
        @endforelse
    </table>

{{-- pagination --}}
    {!! $tasks->links() !!}
@endsection
