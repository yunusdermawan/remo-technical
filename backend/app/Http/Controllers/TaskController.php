<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Task::latest()->paginate(10)
        );
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return response()->json($task, 201);
    }

    public function updateStatus(
        UpdateTaskStatusRequest $request,
        Task $task
    ): JsonResponse {
        $task->update([
            'status' => $request->status,
        ]);

        return response()->json($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
