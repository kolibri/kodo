<?php

namespace App\Tests\Project;

use App\Git\Repo;
use App\Project\StateResolver;
use App\Project\Task;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StateResolverTest extends TestCase
{
    /** @var Repo|MockObject $repo */
    private $repo;
    /** @var Task|MockObject $task */
    private $task;
    /** @var StateResolver */
    private $resolver;

    public function testResolvingOpenState()
    {
        static::assertSame('open', $this->resolver->resolveState(new Task('name', 'some content', 'todo')));
    }

    public function testResolvingProgressState()
    {
        $this->repo->method('hasBranch')->willReturn(true);

        static::assertSame('in progress', $this->resolver->resolveState(new Task('name', 'some content', 'todo')));
    }

    public function testResolvingDoneState()
    {
        $this->repo->method('hasBranch')->willReturn(true);
        $this->repo->method('hasBranchMerged')->willReturn(true);

        static::assertSame('done', $this->resolver->resolveState(new Task('name', 'some content', 'todo')));
    }

    protected function setUp()
    {
        $this->repo = $this->createMock(Repo::class);
        $this->resolver = new StateResolver($this->repo);
        $this->task = $this->createMock(Task::class);
        $this->task->method('getBasename')->willReturn('test');
    }
}
