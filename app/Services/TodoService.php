<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TodoService
{
    public function fetchUserTodos($userId = null)
    {
        $url = config('services.todo_service.url');
        $response = Http::get($url);
        $todos = $response->json();

        if ($userId) {
            return array_filter($todos, fn($todo) => $todo['userId'] == $userId);
        }

        return $todos;
    }

    public function countCompletedTasks($userTodos, $totalTasks): int
    {
        // $completedTasks = $totalTasks;
        // Uncomment the previous line and comment out this line to trigger the AllTasksCompleted event.
        $completedTasks = count(array_filter($userTodos, fn($todo) => $todo['completed']));
        return $completedTasks;
    }
}
