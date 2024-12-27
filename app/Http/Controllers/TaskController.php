<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();
        if ($request->has('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }
        if ($request->has('sort') && $request->sort === 'due_date') {
            $query->orderBy('due_date', 'asc');
        } else {
            $query->latest();
        }
        $tasks = $query->paginate(5);
        return view('tasks.index', compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        Task::create($request->only(['name', 'detail', 'status', 'due_date']));

        return redirect()->route('tasks.index')
                        ->with('success', 'Task created successfully.');
    }

    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }
    public function update(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        $task->update($request->only(['name', 'detail', 'status', 'due_date']));

        return redirect()->route('tasks.index')
                        ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')
                        ->with('success', 'Task deleted successfully.');
    }
}
