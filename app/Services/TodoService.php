<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TodoService
{
    public function fetchUserTodos($userId)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/todos');
        $todos = $response->json();
        return array_filter($todos, fn($todo) => $todo['userId'] == $userId);
    }

    public function countCompletedTasks($userTodos, $totalTasks): int
    {
        // $completedTasks = $totalTasks;
        // Uncomment the previous line and comment out this line to trigger the AllTasksCompleted event.
        $completedTasks = count(array_filter($userTodos, fn($todo) => $todo['completed']));
        return $completedTasks;
    }
}
