<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class TodoService
{
    public function fetchUserTodos($userId = null)
    {
        $url = config('services.todo_service.url');

        try {
            $response = Http::get($url);
            $response->throw(); // Will throw an exception for HTTP errors
            $todos = $response->json();
        } catch (\Exception $e) {
            Log::error('Failed to fetch user todos: ' . $e->getMessage());
            return [];
        }

        if ($userId) {
            return array_filter($todos, fn($todo) => $todo['userId'] == $userId);
        }

        return $todos;
    }

    public function ensureUsersExistInDatabase(): void
    {
        $apiUsers = $this->fetchUserTodos(); // Get all users from the API
        $apiUserIds = array_unique(array_column($apiUsers, 'userId')); // Get all the unique userIds from the API

        // Check how many users from the API already exist in the database
        $existingUsersCount = User::whereIn('id', $apiUserIds)->count();

        // If not all users from the API are in the database, start the seeder
        if ($existingUsersCount < count($apiUserIds)) {
            // Start the seeder to add users
            Artisan::call('app:create-admin-users');
        }
    }

    public function countCompletedTasks($userTodos, $totalTasks): int
    {
        // $completedTasks = $totalTasks;
        // Uncomment the previous line and comment out this line to trigger the AllTasksCompleted event.
        $completedTasks = count(array_filter($userTodos, fn($todo) => $todo['completed']));
        return $completedTasks;
    }
}
