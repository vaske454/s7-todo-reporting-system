<?php
namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Mail\TaskReportMail;
use App\Models\User;

class ReportService
{
    public function generateAndSendReport($userId): void
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/todos');
        $todos = $response->json();

        $userTodos = array_filter($todos, fn($todo) => $todo['userId'] == $userId);

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
        $reportsPath = storage_path('app/reports');

        if (!file_exists($reportsPath)) {
            mkdir($reportsPath, 0755, true);
        }

        $pdfPath = $reportsPath . '/report.pdf';

        Pdf::loadView('report', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'incompletedTasks' => $incompletedTasks,
            'completionRate' => $completionRate,
            'chartPath' => $chartPath
        ])->setPaper('a4', 'landscape')->save($pdfPath);

        $user = User::query()->where('id', $userId)->first();

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        Mail::to($user->email)->send(new TaskReportMail($user, $pdfPath, $chartPath));

        unlink($pdfPath);
        unlink($chartPath);
    }
}
