<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Mail\TaskReportMail;
use App\Models\User;
use App\Events\AllTasksCompleted;

class ReportService
{
    public function generateAndSendReport($userId): void
    {
        // Fetch and filter user todos
        $userTodos = $this->fetchUserTodos($userId);

        // Calculate statistics
        $totalTasks = count($userTodos);
        $completedTasks = $this->countCompletedTasks($userTodos, $totalTasks);
        $incompletedTasks = $totalTasks - $completedTasks;
        $completionRate = $this->calculateCompletionRate($totalTasks, $completedTasks);

        // Generate chart and PDF
        $chartPath = $this->generateChart($completionRate);
        $pdfPath = $this->generatePdf($totalTasks, $completedTasks, $incompletedTasks, $completionRate, $chartPath);

        // Get user and send email
        $user = $this->getUser($userId);
        $this->sendReportEmail($user, $pdfPath, $chartPath);

        // Trigger event if all tasks are completed
        $this->triggerCompletionEvent($completedTasks, $totalTasks, $user);

        // Cleanup
        $this->cleanup($pdfPath, $chartPath);
    }

    private function fetchUserTodos($userId)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/todos');
        $todos = $response->json();
        return array_filter($todos, fn($todo) => $todo['userId'] == $userId);
    }

    private function countCompletedTasks($userTodos, $totalTasks): int
    {
        // $completedTasks = $totalTasks;
        // Uncomment the previous line and comment out this line to trigger the AllTasksCompleted event.
        $completedTasks = count(array_filter($userTodos, fn($todo) => $todo['completed']));
        return $completedTasks;
    }

    private function calculateCompletionRate($totalTasks, $completedTasks): float
    {
        return $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
    }

    private function generateChart($completionRate): string
    {
        $process = new Process(['node', base_path('node_scripts/generateChart.js'), $completionRate]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return public_path('chart-image.png');
    }

    private function generatePdf($totalTasks, $completedTasks, $incompletedTasks, $completionRate, $chartPath): string
    {
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

        return $pdfPath;
    }

    private function getUser(int $userId): ?Model
    {
        $user = User::query()->where('id', $userId)->first();

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user;
    }

    private function sendReportEmail($user, string $pdfPath, string $chartPath): void
    {
        Mail::to($user->email)->send(new TaskReportMail($user, $pdfPath, $chartPath));
    }

    private function triggerCompletionEvent($completedTasks, $totalTasks, $user): void
    {
        if ($completedTasks === $totalTasks && $totalTasks > 0) {
            event(new AllTasksCompleted($user));
        }
    }

    private function cleanup(string $pdfPath, string $chartPath): void
    {
        unlink($pdfPath);
        unlink($chartPath);
    }
}
