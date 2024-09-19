<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin users for the application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Run the seed command first
        $this->info('Running seed command...');

        // Run the seed command using Artisan
        $exitCode = Artisan::call('db:seed', [
            '--class' => 'UserSeeder',
        ]);

        // Check if the process was successful
        if ($exitCode !== 0) {
            $this->error('Seed command failed. Please check the error above.');
            return;
        }

        $this->info('Seed command completed successfully.');

        // Retrieve the last non-admin user from the 'users' table
        $lastNonAdminUser = DB::table('users')
            ->where('is_admin', false)
            ->orderBy('id', 'desc')
            ->first();

        $nextId = $lastNonAdminUser->id + 1;

        // Define admin users
        $admins = [
            [
                'name' => 'Admin User 1',
                'email' => 'admin1@example.com',
                'password' => Hash::make('adminpassword1'),
            ],
            [
                'name' => 'Admin User 2',
                'email' => 'admin2@example.com',
                'password' => Hash::make('adminpassword2'),
            ],
        ];

        // Increment ID for each admin user
        foreach ($admins as $index => $admin) {
            // Check if the user already exists
            $existingUser = DB::table('users')->where('email', $admin['email'])->first();

            if ($existingUser) {
                $this->error('User with email ' . $admin['email'] . ' already exists. Skipping creation.');
                continue; // Skip to the next admin user
            }

            // Insert the new admin user
            DB::table('users')->insert(
                array_merge($admin, [
                    'id' => $nextId + $index,
                    'is_admin' => true,
                    'email_verified_at' => Carbon::now(),
                    'remember_token' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])
            );
        }

        // Notify the user that admin users were created successfully
        $this->info('Command finished successfully!');
    }
}
