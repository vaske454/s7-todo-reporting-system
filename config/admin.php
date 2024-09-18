<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin User Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file contains credentials for the admin users of the
    | application. Each entry should include the user's name, email, and
    | password. These credentials are used to seed the database with initial
    | admin users.
    |
    | You can add or modify admin users as needed. Ensure that passwords are
    | securely handled and consider using environment variables for sensitive
    | data in production environments.
    |
    | Note: Email addresses in this configuration must be unique. If an email
    | address already exists in the database, the user with that email will
    | not be created to avoid duplicates. Make sure to use distinct email
    | addresses for each admin user.
    |
    */

    'admins' => [
        [
            'name' => 'Admin User 1',
            'email' => 'admin1@example.com',
            'password' => 'adminpassword1',
        ],
        [
            'name' => 'Admin User 2',
            'email' => 'admin2@example.com',
            'password' => 'adminpassword2',
        ],
    ],
    // Add more users as needed
];
