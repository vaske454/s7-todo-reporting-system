<?php

namespace App\Services;

class CleanupService
{
    public function cleanup(string $pdfPath, string $chartPath): void
    {
        unlink($pdfPath);
        unlink($chartPath);
    }
}
