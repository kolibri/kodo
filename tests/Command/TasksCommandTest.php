<?php

namespace App\Tests\Command;

use App\Test\FixtureRepo;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @coversNothing
 */
class TasksCommandTest extends KernelTestCase
{
    private const CACHE_DIR = __DIR__.'/ProjectCommandTestDataCache';

    private $commandTester;
    private $fixtureRepo;

    public function testExecute()
    {
        // initial adding of tasks
        $this->fixtureRepo->modifyFilesInBranch(
            [
                'project/plan/00-tests-green' => '# tests must be green',
                'project/plan/01-progress-state' => '# progress state is shown',
                'project/plan/02-done-state' => '# progress state is shown',
            ],
            'master',
            'added todos'
        );
        $this->assertLinesInOutput(
            [
                'tests must be green (open)',
                'progress state is shown (open)',
                'progress state is shown (open)',
            ]
        );

        // create first branch ...
        $this->fixtureRepo->modifyFilesInBranch(
            [
                'project/plan/00-tests-green' => '# tests must be green, forever!',
            ],
            'plan/00-tests-green',
            'tests done'
        );
        $this->assertLinesInOutput(
            [
                'tests must be green, forever! (in progress)',
                'progress state is shown (open)',
                'progress state is shown (open)',
            ]
        );

        // ... and merge it
        $this->fixtureRepo->mergeIntoMaster('plan/00-tests-green');
        $this->assertLinesInOutput(
            [
                'tests must be green, forever! (done)',
                'progress state is shown (open)',
                'progress state is shown (open)',
            ]
        );

        // second branch, will result in all three states
        $this->fixtureRepo->modifyFilesInBranch(
            [
                'project/plan/01-progress-state' => '# See the progress state!',
            ],
            'plan/01-progress-state',
            'progress over'
        );
        $this->assertLinesInOutput(
            [
                'tests must be green, forever! (done)',
                'See the progress state! (in progress)',
                'progress state is shown (open)',
            ]
        );
    }

    private function assertLinesInOutput(array $lines): void
    {
        $this->commandTester->execute(['--repo' => self::CACHE_DIR, '--tasks' => 'project']);
        $output = $this->commandTester->getDisplay();

        foreach ($lines as $line) {
            $this->assertContains($line, $output);
        }
    }

    protected function setUp(): void
    {
        $this->fixtureRepo = new FixtureRepo(self::CACHE_DIR);
        $this->fixtureRepo->init();

        parent::setUp();

        $kernel = static::createKernel();
        $app = new Application($kernel);
        $command = $app->find('app:tasks');
        $this->commandTester = new CommandTester($command);
    }

    protected function tearDown(): void
    {
        $this->fixtureRepo->remove();
        parent::tearDown();
    }
}
