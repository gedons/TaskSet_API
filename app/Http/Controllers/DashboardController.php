<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DashboardResource;
use App\Models\Task;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
       
        // Total Number of Task for the User
        $userTask = Task::where('user_id', $user->id)->count();                
        
        // Latest task
        $userLatest = Task::query()->where('user_id', $user->id)->latest('created_at')->first();

        // Completed Tasks
        $userCompleted = Task::where('user_id', $user->id)
        ->where('status', 'finished')
        ->count();

        // Incomplete Tasks
        $userIncompleted = Task::where('user_id', $user->id)
        ->where('status', 'pending')
        ->count();

        // Overdue Tasks
        $userOverdue = Task::where('user_id', $user->id)
        ->where('status', 'pending')
        ->whereDate('due_date', '<', Carbon::now())
        ->count();
        
                  
        return [
            'totalTask' => $userTask,            
            'latestTask' => $userLatest ? new DashboardResource($userLatest) : null,  
            'completedTasks' => $userCompleted, 
            'incompleteTasks' => $userIncompleted, 
            'overdueTasks' => $userOverdue,       
        ];


    }

    // public function getTaskChart(Request $request)
    // {
    //     $user = $request->user();

    //     $completedTasks = Task::where('user_id', $user->id)
    //     ->where('status', 'finished')
    //     ->count();
        
    //     $incompleteTasks = Task::where('user_id', $user->id)
    //     ->where('status', 'pending')
    //     ->count();

    //     return response()->json([
    //         'completedTasks' => $completedTasks,
    //         'incompleteTasks' => $incompleteTasks,
    //     ]);
    // }
}
