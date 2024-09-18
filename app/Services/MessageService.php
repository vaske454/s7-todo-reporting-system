<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;

class MessageService
{
    public function getSuccessMessage($userId, UserService $userService): RedirectResponse
    {
        $user = $userService->getUser($userId);
        $userName = $user->getAttribute('name');

        return redirect()->route('select-user')->with('success', 'Report sent to ' . $userName . '!');
    }

    public function getErrorMessage($errorMessage): RedirectResponse
    {
        return redirect()->route('select-user')->withErrors(['error' => 'An error occurred: ' . $errorMessage]);
    }
}
