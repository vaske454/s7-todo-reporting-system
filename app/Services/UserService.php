<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;

class UserService
{
    public function getUser(int $userId): ?Model
    {
        $user = User::query()->where('id', $userId)->first();

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user;
    }
}
