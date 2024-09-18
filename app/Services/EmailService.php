<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\TaskReportMail;

class EmailService
{
    public function sendReportEmail($user, string $pdfPath, string $chartPath): void
    {
        Mail::to($user->email)->send(new TaskReportMail($user, $pdfPath, $chartPath));
    }
}
