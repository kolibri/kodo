<?php

declare(strict_types=1);

namespace App\Command;

use App\Test\FixtureRepo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class CreateTestReposCommand extends Command
{
    protected static $defaultName = 'app:fixture:repos:create';

    protected function configure()
    {
        $this->addOption(
            'target_path',
            't',
            InputOption::VALUE_REQUIRED,
            'path to create the repos',
            __DIR__.'/../../example_projects'
        );
        $this->addOption('cleanup', 'c', InputOption::VALUE_NONE, 'if set, all content in target dir will be removed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $targetPath = $input->getOption('target_path');

        $io->writeln(sprintf('Target path is: "%s"', $targetPath));

        $fs = new Filesystem();

        if ($input->getOption('cleanup')) {
            $io->writeln('Cleanup target path');

            $fs->remove($targetPath);
            $fs->mkdir($targetPath);
        }

        $io->writeln('Create simple sample Repository');
        $this->simpleSampleRepo($targetPath);

        return 0;
    }

    /**
     * Will Result in:.
     *
     * plan:
     *     00-tests-green (done)
     *     01-progress-state (in progress)
     *     02-done-state (open)
     * current:
     *     04-more-to-do (done)
     *     05-not-done-yet (in progress)
     *     06-some-feature (open)
     */
    private function simpleSampleRepo(string $basePath)
    {
        $repoPath = $basePath.'/simple_sample';

        $fixtureRepo = new FixtureRepo($repoPath);
        $fixtureRepo->init();

        $fixtureRepo->modifyFilesInBranch(
            [
                'project/plan/00-tests-green' => '# tests must be green',
                'project/plan/01-progress-state' => '# progress state is shown',
                'project/plan/02-done-state' => '# progress state is shown',
                'project/current/04-more-to-do' => '# there is more',
                'project/current/05-not-done-yet' => '# You should do this one',
                'project/current/06-some-feature' => '# we are not going live without this',
            ],
            'master',
            'added todos'
        );

        $fixtureRepo->modifyFilesInBranch(
            ['project/plan/00-tests-green' => '# tests must be green, forever!'],
            'plan/00-tests-green',
            'tests done'
        );
        $fixtureRepo->mergeIntoMaster('plan/00-tests-green');

        $fixtureRepo->modifyFilesInBranch(
            ['project/plan/01-progress-state' => '# See the progress state!'],
            'plan/01-progress-state',
            'progress over'
        );

        $fixtureRepo->getRepo()->checkout('master');

        $fixtureRepo->modifyFilesInBranch(
            ['project/current/04-more-to-do' => '# nothing left'],
            'current/04-more-to-do',
            'where is it'
        );
        $fixtureRepo->mergeIntoMaster('current/04-more-to-do');

        $fixtureRepo->modifyFilesInBranch(
            ['project/current/05-not-done-yet' => '# It is done'],
            'current/05-not-done-yet',
            'did it'
        );
    }
}
