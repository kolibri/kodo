<?php

namespace App\Tests\Git;

use App\Git\Repo;
use Cz\Git\GitRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RepoTest extends TestCase
{
    /** @var GitRepository|MockObject */
    private $gitRepository;

    /** @var Repo */
    private $repo;

    public function setUp()
    {
        $this->gitRepository = $this->createMock(GitRepository::class);

        $this->repo = new Repo($this->gitRepository);
    }

    public function testHasBranch()
    {
        $this->gitRepository->method('getBranches')->willReturn(['master', 'testing']);

        static::assertTrue($this->repo->hasBranch('testing'));
        static::assertFalse($this->repo->hasBranch('develop'));
    }

    public function testHasBranchMerged()
    {
        $this->gitRepository->method('execute')->willReturn(
            [
                'HEAD -> testing',
                'master, testing',
            ]
        );
        static::assertTrue($this->repo->hasBranchMerged('testing'));
        static::assertFalse($this->repo->hasBranchMerged('develop'));
    }
}
