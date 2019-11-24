<?php

namespace App\Project;

use App\Git\Repo;

class StateResolver
{
    private $repo;

    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function resolveState(Task $task): string
    {
        if ($this->repo->hasBranchMerged($task->getBasename())) {
            return 'done';
        }

        if ($this->repo->hasBranch($task->getBasename())) {
            return 'in progress';
        }

        return 'open';
    }
}
