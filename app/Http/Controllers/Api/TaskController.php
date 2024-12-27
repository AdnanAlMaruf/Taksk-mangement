<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
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

        return response()->json([
            'data' => $tasks->items(),
            'pagination' => [
                'total' => $tasks->total(),
                'current_page' => $tasks->currentPage(),
                'per_page' => $tasks->perPage(),
                'last_page' => $tasks->lastPage(),
                'next_page_url' => $tasks->nextPageUrl(),
                'prev_page_url' => $tasks->previousPageUrl(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required|string|max:255',
                'detail' => 'required|string',
                'status' => 'required|in:Pending,In Progress,Completed',
                'due_date' => 'nullable|date|after_or_equal:today',
            ];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 402);
            }
            $task = new Task();
            $task->name = $data['name'];
            $task->detail = $data['detail'];
            $task->status = $data['status'];
            $task->due_date = $data['due_date'];
            $task->save();
            $message = 'User successfully Added';
            return response()->json(['message' => $message], 201);
        }
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }

    // public function update(Request $request,$id)
    // {

    //     if($request->isMethod('put')){
    //         $data=$request->all();
    //         $rules=[
    //             'name' => 'required|string|max:255',
    //             'detail' => 'required|string',
    //             'status' => 'required|in:Pending,In Progress,Completed',
    //             'due_date' => 'nullable|date|after_or_equal:today',
    //         ];
    //         $validator = Validator::make($data,$rules);
    //         if($validator->fails())
    //         {
    //             return response()->json($validator->errors(),422);
    //         }
    //         $task=  Task::find($id);
    //         if (!$task) {
    //             return response()->json(['error' => 'Task not found'], 404); // Return a 404 if task not found
    //         }
    //         $task->name = $data['name'];
    //         $task->detail = $data['detail'];
    //         $task->status = $data['status'];
    //         $task->due_date = $data['due_date'];
    //         $task->save();
    //         $message = 'User successfully Updated';
    //         return response()->json(['message'=>$message],202);
    //     }
    // }
    public function update(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $data = $request->all();

            // Validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'detail' => 'required|string',
                'status' => 'required|in:Pending,In Progress,Completed',
                'due_date' => 'nullable|date|after_or_equal:today',
            ];

            // Validate the request data
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422); // Validation error
            }

            // Find the task
            $task = Task::find($id);
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404); // Task not found
            }

            // Update task properties
            try {
                $task->name = $data['name'];
                $task->detail = $data['detail'];
                $task->status = $data['status'];
                $task->due_date = $data['due_date'];
                $task->save();

                return response()->json(['message' => 'Task successfully updated'], 202);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500); // Catch unexpected errors
            }
        }

        return response()->json(['error' => 'Invalid request method'], 405); // Method not allowed
    }


    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        $message = 'User Successfully Deleted';
        return response()->json(['message' => $message], 200);
    }
}
