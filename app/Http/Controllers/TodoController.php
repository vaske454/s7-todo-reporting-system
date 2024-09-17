<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TodoController extends Controller
{
    /**
     * Display a form with a user select dropdown.
     *
     * @return View
     */
    public function showForm(): View
    {
        $users = User::all();
        return view('select-user', compact('users'));
    }

    public function generateReport(Request $request): StreamedResponse|RedirectResponse
    {
        $userId = $request->input('user_id');

        if ($request->isMethod('get')) {
            return redirect()->route('select-user')->withErrors(['user_id' => 'User ID is required']);
        }

        if (!$userId) {
            return redirect()->route('select-user')->withErrors(['user_id' => 'User ID is required']);
        }

        $response = Http::get('https://jsonplaceholder.typicode.com/todos');
        $todos = $response->json();

        $userTodos = array_filter($todos, function ($todo) use ($userId) {
            return $todo['userId'] == $userId;
        });

        $totalTasks = count($userTodos);
        $completedTasks = count(array_filter($userTodos, fn($todo) => $todo['completed']));
        $incompletedTasks = $totalTasks - $completedTasks;
        $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $process = new Process(['node', base_path('node_scripts/generateChart.js'), $completionRate]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $chartPath = public_path('chart-image.png');

        $pdf = Pdf::loadView('report', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'incompletedTasks' => $incompletedTasks,
            'completionRate' => $completionRate,
            'chartPath' => $chartPath
        ])->setPaper('a4', 'landscape')->output();

        return response()->stream(
            function () use ($pdf) {
                echo $pdf;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="report.pdf"',
            ]
        );
    }
}
