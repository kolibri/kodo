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

    public function resolveState(string $basename): string
    {
        if ($this->repo->hasBranchMerged($basename)) {
            return 'done';
        }

        if ($this->repo->hasBranch($basename)) {
            return 'in progress';
        }

        return 'open';
    }
}
