<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Form</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-6 rounded-lg shadow-md" style="width: 400px; max-width: 100%;">
    <a href="/" class="text-indigo-600 hover:text-indigo-800 text-sm block mb-4">Go to Homepage</a>
    <h1 class="text-xl font-semibold mb-4 text-gray-800">Select a User</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="mb-4">
            <div class="text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('generate-report') }}" class="space-y-4">
        @csrf
        <div>
            <label for="user" class="block text-sm font-medium text-gray-700">Select User:</label>
            <select name="user_id" id="user" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" style="background: black; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.3s; cursor: pointer;" onmouseover="this.style.backgroundColor='#4B4B4B'" onmouseout="this.style.backgroundColor='black'" class="w-full mt-6 py-2 px-4 rounded-md">
            Generate Report
        </button>
    </form>
</div>

</body>
</html>
