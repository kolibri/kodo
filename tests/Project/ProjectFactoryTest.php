<?php

declare(strict_types=1);

namespace App\Tests\Project;

use App\Project\ProjectFactory;
use App\Project\StateResolver;
use App\Project\StateResolverFactory;
use PHPUnit\Framework\TestCase;

class ProjectFactoryTest extends TestCase
{
    public function testCreationOfNewProject()
    {
        $stateResolver = $this->createMock(StateResolver::class);
        $stateResolverFactory = $this->createMock(StateResolverFactory::class);
        $stateResolverFactory->method('createStateResolver')->willReturn($stateResolver);
        $factory = new ProjectFactory($stateResolverFactory);
        $project = $factory->createProject('/tmp/foo', 'tasks');

        static::assertSame('/tmp/foo', $project->getRepoDir());
        static::assertSame('/tmp/foo/tasks', $project->getTasksDir());
    }
}
