<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $index) {
            // Check if the user with specific ID exists
            $existingUser = DB::table('users')->where('id', $index)->first();

            // If the user doesn't exist, insert them with a specific ID
            if (!$existingUser) {
                DB::table('users')->insert([
                    'id' => $index, // Manually set the ID
                    'name' => "User {$index}",
                    'email' => "user{$index}@example.com",
                    'password' => Hash::make("password{$index}"), // Hash the password
                ]);
            }
        }

        // Alternative method: Manually insert predefined users
        // Uncomment the block below if you prefer a predefined set of users,
        // and comment out the dynamic user creation code above.

        /*
        DB::table('users')->insert([
            ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => Hash::make('password')],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => Hash::make('password')],
            ...
        ]);
        */
    }
}
