<?php

declare(strict_types=1);

namespace App\Project;

class ProjectFactory
{
    /** @var StateResolver */
    private $stateResolverFactory;

    public function __construct(StateResolverFactory $stateResolverFactory)
    {
        $this->stateResolverFactory = $stateResolverFactory;
    }

    public function createProject(string $repoPath, string $tasksPath): Project
    {
        return new Project($repoPath, $tasksPath, $this->stateResolverFactory->createStateResolver($repoPath));
    }
}
