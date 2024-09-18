<?php

namespace App\Services;

use App\Events\AllTasksCompleted;

class EventService
{
    public function triggerCompletionEvent($completedTasks, $totalTasks, $user): void
    {
        if ($completedTasks === $totalTasks && $totalTasks > 0) {
            event(new AllTasksCompleted($user));
        }
    }
}
