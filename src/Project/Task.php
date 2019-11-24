<?php

namespace App\Project;

class Task
{
    private $basename;
    private $content;

    public function __construct(string $basename, string $content)
    {
        $this->basename = $basename;
        $this->content = $content;
    }

    public function getTitle(): string
    {
        if (preg_match('/^\s*#\s+(.*)/', $this->content, $matches)) {
            return $matches[1];
        }

        return $this->basename;
    }

    public function getDescription(): string
    {
        return $this->content;
    }

    public function getBasename()
    {
        return $this->basename;
    }
}
