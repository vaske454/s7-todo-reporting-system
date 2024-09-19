<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use App\Models\User;
use Illuminate\View\View;

class UserSelectionController extends Controller
{
    protected TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a form with a user select dropdown.
     *
     * @return View
     */
    public function showForm(): View
    {
        // Fetch all users from the database
        $users = User::all();

        // Ensure that all users from the API exist in the database
        $this->todoService->ensureUsersExistInDatabase();

        // Fetch all users from the API
        $apiUsers = $this->todoService->fetchUserTodos();

        // Get all unique userId values from the API
        $apiUserIds = array_unique(array_column($apiUsers, 'userId'));

        // Filter users who are not admins and are among the users fetched from the API
        $filteredUsers = $users->filter(function ($user) use ($apiUserIds) {
            return !$user->is_admin && in_array($user->id, $apiUserIds);
        });

        // Return the view with filtered users
        return view('select-user', ['users' => $filteredUsers]);

    }
}
