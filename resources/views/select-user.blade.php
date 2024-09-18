<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Form</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Add CSS -->
    @vite(['resources/css/components/select-user.css'])
</head>
<body class="flex-container">
<livewire:layout.navigation />
<main class="content">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
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
            <button type="submit" class="w-full mt-6 py-2 px-4 rounded-md bg-black text-white border-none transition-colors duration-300 hover:bg-gray-700">
                Generate Report
            </button>
        </form>
    </div>
</main>

<!-- Success Popup -->
<div id="success-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div id="popup-content" class="bg-white p-6 rounded-lg max-w-md w-full text-center shadow-lg">
        @if (session('success'))
            <p class="js-success-message text-lg font-semibold text-indigo-600">{{ session('success') }}</p>
        @endif
    </div>
</div>

<!-- Meta tag for JavaScript -->
@if (session('success'))
    <meta name="success-message" content="1">
@endif

{{--@vite(['resources/js/app.js'])--}}
@vite(['resources/js/components/select-user.js'])
</body>
</html>
