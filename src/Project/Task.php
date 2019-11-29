<?php

namespace App\Project;

class Task
{
    private $basename;
    private $content;
    private $status;
    private $lane;

    public function __construct(string $basename, string $content, string $lane)
    {
        $this->basename = $basename;
        $this->content = $content;
        $this->status = 'open';
        $this->lane = $lane;
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

    public function getBasename(): string
    {
        return $this->basename;
    }

    public function getLane(): string
    {
        return $this->lane;
    }

    public function getBranchname(): string
    {
        return sprintf('%s/%s', $this->lane, $this->basename);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
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
