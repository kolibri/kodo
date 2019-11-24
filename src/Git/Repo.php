<?php

namespace App\Git;

use Cz\Git\GitRepository;

class Repo
{
    private $gitRepository;

    public function __construct(GitRepository $gitRepository)
    {
        $this->gitRepository = $gitRepository;
    }

    public function hasBranch(string $branch): bool
    {
        return in_array($branch, $this->gitRepository->getBranches(), true);
    }

    public function hasBranchMerged(string $branch, string $target = 'master'): bool
    {
        //dump($this->gitRepository->execute('git --no-pager log --pretty=format:%D'));
        $merges = $this->gitRepository->execute(['log', '--pretty=format:%D']);

        foreach ($merges as $merge) {
            if (empty($merge)) {
                continue;
            }
            $branches = explode(', ', substr($merge, strpos('HEAD -> ', $merge)));
            if (in_array($branch, $branches, true)) {
                return true;
            }
        }

        return false;
    }
}
