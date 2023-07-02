<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return TaskResource::collection(Task::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(8));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $task = Task::create($data);

        return new TaskResource($task);

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $task->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        // Update task in the database
        $task->update($data);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $task->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        $task->delete();
        return response('', 204);
    }
}
