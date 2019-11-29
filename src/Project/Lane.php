<?php

declare(strict_types=1);

namespace App\Project;

class Lane
{
    private $tasks;
    private $name;

    public function __construct(string $name, array $tasks)
    {
        $this->name = $name;
        $this->tasks = $tasks;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @return Task[] */
    public function getTasks(): array
    {
        return $this->tasks;
    }
}
