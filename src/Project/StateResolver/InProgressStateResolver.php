<?php

declare(strict_types=1);

namespace App\Project\StateResolver;

use App\Project\Task;

class InProgressStateResolver implements StateResolverInterface
{
    public function resolveState(Task $task): string
    {
    }
}
