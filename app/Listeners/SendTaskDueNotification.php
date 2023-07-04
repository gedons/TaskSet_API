<?php

namespace App\Listeners;

use App\Events\TaskDue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\TaskDueNotification;
use Illuminate\Support\Facades\Mail;


class SendTaskDueNotification implements ShouldQueue

{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskDue $event): void
    {
        $task = $event->task;
        $user = $task->user;

        // Send the email notification
        Mail::to($user->email)->send(new TaskDueNotification($task));
    }
}
