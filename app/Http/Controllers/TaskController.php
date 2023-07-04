<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Mail\TaskDueNotification;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return TaskResource::collection(Task::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(7));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $task = Task::create($data);

        $task->markAsDue();

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

        $task->markAsDue();

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

    public function markCompleted(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Update the task status to "finished"
        $task->status = 'finished';
        $task->save();
        

        return response()->json(['message' => 'Task marked as completed'], 200);
    }

    public function markIncompleted(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Update the task status to "pending"
        $task->status = 'pending';
        $task->save();

        $task->markAsDue();

        return response()->json(['message' => 'Task marked as incompleted'], 200);
    }

    // public function sendTaskDueNotifications()
    // {
    //     $dueTasks = Task::dueTasks();

    //     foreach ($dueTasks as $task) {
    //         // Get the user associated with the task
    //         $user = $task->user;

    //         // Send the email notification
    //         Mail::to($user->email)->send(new TaskDueNotification($task));
    //     }
    // }
}
