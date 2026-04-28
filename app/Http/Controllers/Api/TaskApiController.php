<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $tasks = Task::query()
            ->with(['legalCase', 'assignee'])
            ->latest()
            ->paginate(15);

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = Task::query()->create($request->validated());
        $task->load(['legalCase', 'assignee', 'creator']);

        return new TaskResource($task);
    }

    public function show(Task $task): TaskResource
    {
        $task->load(['legalCase', 'assignee', 'creator']);

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $task->update($request->validated());
        $task->load(['legalCase', 'assignee', 'creator']);

        return new TaskResource($task->fresh());
    }

    public function destroy(Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}
