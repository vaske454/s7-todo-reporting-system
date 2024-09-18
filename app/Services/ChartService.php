<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ChartService
{
    public function generateChart($completionRate): string
    {
        $process = new Process(['node', base_path('node_scripts/generateChart.js'), $completionRate]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return public_path('chart-image.png');
    }
}
