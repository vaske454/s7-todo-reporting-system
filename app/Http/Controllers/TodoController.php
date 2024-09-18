<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TodoController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

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

        if (!$userId) {
            return redirect()->route('select-user')->withErrors(['user_id' => 'User ID is required']);
        }

        try {
            $this->reportService->generateAndSendReport($userId);
            return redirect()->route('select-user')->with('success', 'Report sent to user!');
        } catch (\Exception $e) {
            return redirect()->route('select-user')->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
