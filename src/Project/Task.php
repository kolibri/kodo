<?php

namespace App\Project;

use Symfony\Component\Finder\SplFileInfo;

class Task
{
    private $file;
    private $state;

    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
        $this->state = 'open';
    }

    public function getTitle(): string
    {
        if (preg_match('/^\s*#\s+(.*)/', $this->file->getContents(), $matches)) {
            return $matches[1];
        }

        return $this->file->getFilename();
    }

    public function getDescription(): string
    {
        return $this->file->getContents();
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getBasename()
    {
        return $this->file->getBasename('.md');
    }
}
