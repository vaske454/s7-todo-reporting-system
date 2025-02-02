<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TODO Report</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<h1>TODO Report</h1>
<p>Total Tasks: {{ $totalTasks }}</p>
<p>Completed Tasks: {{ $completedTasks }}</p>
<p>Incomplete Tasks: {{ $incompletedTasks }}</p>
<p>Completion Rate: {{ number_format($completionRate, 2) }}%</p>

<div class="chart">
    <img src="{{ $chartPath }}" alt="Chart">
</div>
</body>
</html>
