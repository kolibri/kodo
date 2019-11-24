<?php

namespace App\Project;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Project
{
    private $projectDir;
    private $finder;
    private $stateResolver;

    public function __construct(string $projectDir, Finder $finder, StateResolver $stateResolver)
    {
        $this->projectDir = $projectDir;
        $this->finder = $finder;
        $this->stateResolver = $stateResolver;
    }

    /** @return Task[] */
    public function getTasks(): array
    {
        /** @var SplFileInfo[] $files */
        $files = $this->finder->files()->in($this->projectDir);
        $tasks = [];
        foreach ($files as $file) {
            $basename = $file->getBasename('.md');
            $tasks[] = new Task($basename, $file->getContents(), $this->stateResolver->resolveState($basename));
        }

        return $tasks;
    }
}
