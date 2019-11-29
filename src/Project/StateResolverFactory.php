<?php

declare(strict_types=1);

namespace App\Project;

use App\Git\Repo;
use Cz\Git\GitRepository;

class StateResolverFactory
{
    public function createStateResolver(string $repoPath)
    {
        return new StateResolver(new Repo(new GitRepository($repoPath)));
    }
}
