<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AllTasksCompleted
{
    use Dispatchable, SerializesModels;

    public mixed $user;

    /**
     * Create a new event instance.
     *
     * @param mixed $user
     * @return void
     */
    public function __construct(mixed $user)
    {
        $this->user = $user;
    }
}
