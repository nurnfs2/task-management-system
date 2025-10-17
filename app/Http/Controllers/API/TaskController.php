<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendTaskNotificationJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }

    use AuthorizesRequests;

    // List all tasks (optionally by status)
    public function index(Request $request)
    {
        $status = $request->query('status'); // start / incomplete / complete
        $cacheKey = 'tasks_all_status_' . ($status ?? 'all');

        $tasks = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($status) {
            $q = Task::with('user')->latest();
            if ($status && in_array($status, ['incomplete', 'complete'])) {
                $q->where('status', $status);
            }
            return $q->get();
        });

        return response()->json($tasks);
    }

    // Create new task
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|unique:tasks,title',
            'description' => 'nullable|string',
            'status'      => ['nullable', Rule::in(['start', 'incomplete', 'complete'])],
        ]);

        $data['user_id'] = Auth::id();
        $data['status']  = $data['status'] ?? 'start';

        $task = Task::create($data);

        Cache::forget('tasks_all_status_all');
        Cache::forget('tasks_all_status_' . $task->status);

        // SendTaskNotificationJob::dispatch($task, 'created');

        return response()->json($task, 201);
    }

    // Show single task
    public function show(Task $task)
    {
        return response()->json($task->load('user'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'title'       => 'required|string|unique:tasks,title,' . $task->id,
            'description' => 'nullable|string',
            'status'      => ['required', Rule::in(['start', 'incomplete', 'complete'])],
        ]);

        $oldStatus = $task->status;
        $task->update($data);

        Cache::forget('tasks_all_status_all');
        Cache::forget('tasks_all_status_' . $oldStatus);
        Cache::forget('tasks_all_status_' . $task->status);

        if ($oldStatus !== $task->status && $task->status === 'complete')
        {
            // SendTaskNotificationJob::dispatch($task, 'completed');
        }

        return response()->json([
            'success' => true,
            'task' => $task->fresh()
        ], 200);
    }

    // Delete task
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        Cache::forget('tasks_all_status_all');
        Cache::forget('tasks_all_status_' . $task->status);

        return response()->json(['message' => 'Deleted'], 200);
    }
}
