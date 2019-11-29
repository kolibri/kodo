<?php

declare(strict_types=1);

namespace App\Project;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectRepository
{
    private $configs;
    private $projectFactory;

    public function __construct(array $configs, ProjectFactory $projectFactory)
    {
        $this->configs = $configs;
        $this->projectFactory = $projectFactory;
    }

    public function getProject(string $name): Project
    {
        if (!array_key_exists($name, $this->configs)) {
            throw new NotFoundHttpException(sprintf('There is no project "%s"', $name));
        }

        $config = $this->configs[$name];

        return $this->projectFactory->createProject($config['repo_path'], $config['tasks_dir']);
    }

    /** @return string[] */
    public function getAllNames(): array
    {
        return array_keys($this->configs);
    }
}
