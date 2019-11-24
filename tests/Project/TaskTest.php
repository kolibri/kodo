<?php

namespace App\Tests\Project;

use App\Project\Task;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @internal
 * @coversNothing
 */
class TaskTest extends TestCase
{
    public function testGeneration()
    {
        $content = <<<'EOF'
# This is test

foobar
EOF;

        /** @var SplFileInfo|MockObject $file */
        $file = $this->createMock(SplFileInfo::class);
        $file->method('getContents')->willReturn($content);
        $file->method('getBasename')->willReturn('testtask');
        $task = new Task($file);

        static::assertSame('This is test', $task->getTitle());
        static::assertSame($content, $task->getDescription());
        static::assertSame('open', $task->getState());
        static::assertSame('testtask', $task->getBasename());
    }
}
