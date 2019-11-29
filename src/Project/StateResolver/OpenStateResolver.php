<?php

declare(strict_types=1);

namespace App\Project\StateResolver;

use App\Project\Task;

class OpenStateResolver implements StateResolverInterface
{
    public function resolveState(Task $task): string
    {
        return 'open';
    }
}
