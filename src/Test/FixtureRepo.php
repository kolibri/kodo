<?php

namespace App\Test;

use Cz\Git\GitRepository;
use Symfony\Component\Filesystem\Filesystem;

class FixtureRepo
{
    private $fs;
    private $repo;
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->fs = new Filesystem();
    }

    public function getRepo()
    {
        return $this->repo;
    }

    public function init()
    {
        $this->fs->mkdir($this->path);
        $this->repo = GitRepository::init($this->path);
        $this->fs->dumpFile($this->path.'/README.md', '# Readme');
        $this->repo->addFile($this->path.'/README.md');
        $this->repo->commit('Inital commit');
    }

    public function modifyFilesInBranch(array $files, string $branch, string $message, bool $commit = true): void
    {
        if ('master' !== $branch) {
            $this->repo->createBranch($branch);
        }

        $this->repo->checkout($branch);

        foreach ($files as $name => $content) {
            $filePath = sprintf('%s/%s.md', $this->path, $name);
            $this->fs->dumpFile($filePath, $content);
            if ($commit) {
                $this->repo->addFile($filePath);
            }
        }

        if ($commit) {
            $this->repo->commit($message);
        }
    }

    public function remove(): void
    {
        $this->fs->remove($this->path);
    }
}
