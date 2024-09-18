<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskReportMail;

class EmailService
{
    public function sendReportEmail($user, string $pdfPath, string $chartPath): void
    {
        $loggedInUser = Auth::user();
        Mail::alwaysFrom($loggedInUser->email, $loggedInUser->name);
        Mail::to($user->email, $user->name)->send(new TaskReportMail($user, $pdfPath, $chartPath));
    }
}
