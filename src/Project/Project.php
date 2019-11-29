<?php

namespace App\Project;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Project
{
    private $repoDir;
    private $tasksDir;
    private $stateResolver;

    public function __construct(string $repoDir, string $projectDir, StateResolver $stateResolver)
    {
        $this->repoDir = $repoDir;
        $this->tasksDir = $projectDir;
        $this->stateResolver = $stateResolver;
    }

    public function getRepoDir(): string
    {
        return $this->repoDir;
    }

    public function getTasksDir(): string
    {
        return sprintf('%s/%s', $this->repoDir, $this->tasksDir);
    }

    /** @return Lane[] */
    public function getLanes(): array
    {
        return array_map(
            function (SplFileInfo $file) {
                $basename = $file->getBasename();

                return new Lane(
                    $basename,
                    $this->createTasks($file->getRealPath(), $file->getBasename())
                );
            },
            iterator_to_array(
                (new Finder())
                    ->depth('== 0')
                    ->directories()
                    ->in($this->getTasksDir())
            )
        );
    }

    /** @return Task[] */
    private function createTasks(string $directory, string $laneName): array
    {
        return array_map(
            function (SplFileInfo $file) use ($laneName, $directory) {
                $basename = $file->getBasename('.md');

                $task = new Task($basename, $file->getContents(), $laneName);
                $task->setStatus($this->stateResolver->resolveState($task));

                return $task;
            },
            iterator_to_array((new Finder())->depth('== 0')->files()->in($directory))
        );
    }
}
