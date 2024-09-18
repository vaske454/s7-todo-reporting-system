<?php

namespace App\Services;

class ReportService
{
    protected TodoService $todoService;
    protected ChartService $chartService;
    protected PdfService $pdfService;
    protected UserService $userService;
    protected EmailService $emailService;
    protected EventService $eventService;
    protected CleanupService $cleanupService;

    public function __construct(
        TodoService $todoService,
        ChartService $chartService,
        PdfService $pdfService,
        UserService $userService,
        EmailService $emailService,
        EventService $eventService,
        CleanupService $cleanupService
    ) {
        $this->todoService = $todoService;
        $this->chartService = $chartService;
        $this->pdfService = $pdfService;
        $this->userService = $userService;
        $this->emailService = $emailService;
        $this->eventService = $eventService;
        $this->cleanupService = $cleanupService;
    }

    public function generateAndSendReport($userId): void
    {
        // Fetch and filter user todos
        $userTodos = $this->todoService->fetchUserTodos($userId);

        // Calculate statistics
        $totalTasks = count($userTodos);
        $completedTasks = $this->todoService->countCompletedTasks($userTodos, $totalTasks);
        $incompletedTasks = $totalTasks - $completedTasks;
        $completionRate = $this->calculateCompletionRate($totalTasks, $completedTasks);

        // Generate chart and PDF
        $chartPath = $this->chartService->generateChart($completionRate);
        $pdfPath = $this->pdfService->generatePdf($totalTasks, $completedTasks, $incompletedTasks, $completionRate, $chartPath);

        // Get user and send email
        $user = $this->userService->getUser($userId);
        $this->emailService->sendReportEmail($user, $pdfPath, $chartPath);

        // Trigger event if all tasks are completed
        $this->eventService->triggerCompletionEvent($completedTasks, $totalTasks, $user);

        // Cleanup
        $this->cleanupService->cleanup($pdfPath, $chartPath);
    }

    private function calculateCompletionRate($totalTasks, $completedTasks): float
    {
        return $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
    }
}
