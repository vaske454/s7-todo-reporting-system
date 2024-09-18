<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Current Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel 10 To-Do Reporting System

## Getting Started

Follow these steps to set up and run the project:

1. **Clone the Repository:**

    ```bash
    git clone git@github.com:vaske454/s7-todo-reporting-system.git
    cd s7-todo-reporting-system
    ```

2. **Install Dependencies:**

    ```bash
    ddev composer install
    npm install
    ```

3. **Start the Development Environment:**

    ```bash
    ddev start
    ```

4. **Run Migrations:**

    ```bash
    ddev php artisan migrate
    ```

5. **Seed the Database with Users:**

    ```bash
    ddev php artisan db:seed --class=UserSeeder
    ```

6. **Access the Application:**

   Open your browser and go to [http://s7-todo-reporting-system.ddev.site](http://s7-todo-reporting-system.ddev.site) to view the application.

## Description

This project is a Laravel 10 application that demonstrates a simple login system and provides functionality for generating reports based on TODO items fetched from an external API.

To access the select-user page and perform operations, you must log in as an admin user. Use one of the following credentials to log in after running the seeder:

### Admin Credentials

**Admin User 1:**
- **Email:** `admin1@example.com`
- **Password:** `adminpassword1`

**Admin User 2:**
- **Email:** `admin2@example.com`
- **Password:** `adminpassword2`

Once logged in as an admin, you will be able to:

1. Go to the [Select User](http://s7-todo-reporting-system.ddev.site/select-user) page.
2. Select a user from the dropdown menu.
3. Fetch TODO items for the selected user from [JSONPlaceholder API](https://jsonplaceholder.typicode.com/todos).
4. Generate a report in the desired format and send it to the selected user's email address. The report includes:
    - Total number of TODO tasks
    - Number of completed tasks
    - Number of incomplete tasks
    - Percentage of completed tasks
    - A pie chart showing the percentage of completed tasks

The email will be sent from the currently logged-in admin user to the selected user after submitting the form.

Additionally, if all TODO tasks for the selected user are completed, an event will trigger, and a congratulatory email will be sent.

## Usage

To run the application after the initial setup, ensure you execute:

```bash
ddev start
```
This will start the development environment and allow you to interact with the application.

If you make changes to JavaScript files or add Tailwind CSS classes, you will need to rebuild the assets. Use the following command to build the assets:

```bash
npm run build
```

This will process and bundle your JavaScript and CSS files for production.
