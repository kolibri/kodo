<?php

namespace App\Project;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Project
{
    private $projectDir;
    private $finder;

    public function __construct(string $projectDir, Finder $finder)
    {
        $this->projectDir = $projectDir;
        $this->finder = $finder;
    }

    /** @return Task[] */
    public function getTasks(): array
    {
        /** @var SplFileInfo[] $files */
        $files = $this->finder->files()->in($this->projectDir);
        $tasks = [];
        foreach ($files as $file) {
            $tasks[] = new Task($file->getBasename('.md'), $file->getContents());
        }

        return $tasks;
    }
}
