<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Generate and send report based on selected user.
     *
     * @param Request $request
     * @return StreamedResponse|RedirectResponse
     */
    public function generateReport(Request $request): StreamedResponse|RedirectResponse
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return redirect()->route('select-user')->withErrors(['user_id' => 'User ID is required']);
        }

        return $this->reportService->generateAndSendReport($userId);
    }
}
