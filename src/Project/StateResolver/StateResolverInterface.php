<?php

declare(strict_types=1);

namespace App\Project\StateResolver;

use App\Project\Task;

interface StateResolverInterface
{
    public function resolveState(Task $task): string;
}
