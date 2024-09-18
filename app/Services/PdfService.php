<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    public function generatePdf($totalTasks, $completedTasks, $incompletedTasks, $completionRate, $chartPath): string
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
}
