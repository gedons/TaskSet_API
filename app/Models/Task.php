<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Events\TaskDue;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsDue()
    {
        $now = Carbon::now();
        $dueDate = Carbon::parse($this->due_date);

        if ($dueDate->isPast() && $now->diffInMinutes($dueDate) >= 0) {
            event(new TaskDue($this));
        }
    }
}
