<?php

namespace App\Tests\Command;

use Cz\Git\GitRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @internal
 * @coversNothing
 */
class ProjectCommandTest extends KernelTestCase
{
    private const CACHE_DIR = __DIR__.'/ProjectCommandTestDataCache';

    private $repo;
    private $fs;
    private $commandTester;

    public function testExecute()
    {
        // initial adding of tasks
        $this->modifyFilesInBranch(
            [
                'project/00-tests-green' => '# tests must be green',
                'project/01-progress-state' => '# progress state is shown',
                'project/02-done-state' => '# progress state is shown',
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
        $this->modifyFilesInBranch(
            [
                'project/00-tests-green' => '# tests must be green, forever!',
            ],
            '00-tests-green',
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
        $this->repo->checkout('master');
        $this->repo->merge('00-tests-green');

        $this->assertLinesInOutput(
            [
                'tests must be green, forever! (done)',
                'progress state is shown (open)',
                'progress state is shown (open)',
            ]
        );

        // second branch, will result in all three states
        $this->modifyFilesInBranch(
            [
                'project/00-progress-state' => '# See the progress state!',
            ],
            '00-progress-state',
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

    private function modifyFilesInBranch(array $files, string $branch, string $message, bool $commit = true): void
    {
        if ('master' !== $branch) {
            $this->repo->createBranch($branch);
        }
        $this->repo->checkout($branch);

        foreach ($files as $name => $content) {
            $filePath = sprintf('%s/%s.md', self::CACHE_DIR, $name);
            $this->fs->dumpFile($filePath, $content);
            if ($commit) {
                $this->repo->addFile($filePath);
            }
        }

        if ($commit) {
            $this->repo->commit($message);
        }
    }

    private function assertLinesInOutput(array $lines): void
    {
        $this->commandTester->execute([]);
        $output = $this->commandTester->getDisplay();

        foreach ($lines as $line) {
            $this->assertContains($line, $output);
        }
    }

    protected function setUp()
    {
        parent::setUp();

        $this->fs = new Filesystem();
        $this->fs->mkdir(self::CACHE_DIR);
        $this->repo = GitRepository::init(self::CACHE_DIR);
        $this->fs->dumpFile(self::CACHE_DIR.'/README.md', '# Readme');
        $this->repo->addFile(self::CACHE_DIR.'/README.md');
        $this->repo->commit('Inital commit');

        $kernel = static::createKernel();
        $app = new Application($kernel);
        $command = $app->find('app:project');
        $this->commandTester = new CommandTester($command);
    }

    protected function tearDown(): void
    {
        $fs = new Filesystem();
        $fs->remove(self::CACHE_DIR);
        parent::tearDown();
    }
}
