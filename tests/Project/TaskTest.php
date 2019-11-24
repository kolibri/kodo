<?php

namespace App\Tests\Project;

use App\Project\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testGeneration()
    {
        $content = <<<'EOF'
# This is test

foobar
EOF;

        $task = new Task('testtask', $content, 'open');

        static::assertSame('This is test', $task->getTitle());
        static::assertSame($content, $task->getDescription());
        static::assertSame('testtask', $task->getBasename());
        static::assertSame('open', $task->getStatus());
        static::assertSame('This is test (open)', $task->getTitleWithState());
    }
}
