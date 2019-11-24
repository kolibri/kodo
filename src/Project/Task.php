<?php

namespace App\Project;

class Task
{
    private $basename;
    private $content;
    private $status;

    public function __construct(string $basename, string $content, string $status)
    {
        $this->basename = $basename;
        $this->content = $content;
        $this->status = $status;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTitleWithState(): string
    {
        return sprintf(
            '%s (%s)',
            $this->getTitle(),
            $this->getStatus()
        );
    }
}
