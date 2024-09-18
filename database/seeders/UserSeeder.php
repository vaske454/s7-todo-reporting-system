<?php

namespace Database\Seeders;

use App\Services\TodoService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    protected TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        // Fetch all todos
        $todos = $this->todoService->fetchUserTodos();

        // Get unique userIds from todos
        $userIds = $this->getUniqueUserIds($todos);

        // Seed users based on the fetched todos
        $this->seedUsers($userIds);

        // Seed admin user
        $this->seedAdmin();
    }

    /**
     * Get unique user IDs from todos.
     */
    protected function getUniqueUserIds(array $todos): array
    {
        return collect($todos)->pluck('userId')->unique()->toArray();
    }

    /**
     * Seed users based on the unique user IDs.
     */
    protected function seedUsers(array $userIds): void
    {
        foreach ($userIds as $userId) {
            $existingUser = DB::table('users')->where('id', $userId)->first();

            if (!$existingUser) {
                DB::table('users')->insert([
                    'id' => $userId,
                    'name' => "User $userId",
                    'email' => "user$userId@example.com",
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make("password$userId"),
                    'remember_token' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Seed the admin user if it doesn't already exist.
     */
    protected function seedAdmin(): void
    {
        $existingAdmin = DB::table('users')->where('email', 'admin@example.com')->first();

        if (!$existingAdmin) {
            DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('adminpassword'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_admin' => true,
            ]);
        }
    }
}
